<?php

namespace App\Services;

use App\Data\RecordTransactionData;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;
use InvalidArgumentException;

class WalletService
{
    /**
     * Deposit into the wallet
     *
     * @param Model $walletable
     * @param float $amount
     * @param string|null $description
     * @return WalletTransaction
     */
    public function deposit(Model $walletable, float $amount, ?string $description = null): WalletTransaction
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException('يجب أن يكون المبلغ أكبر من صفر.');
        }

        return DB::transaction(function () use ($walletable, $amount, $description) {
            $wallet = $this->getOrCreateWallet($walletable, true);
            $transactionNumber = $this->generateRandomTransactionNumber();

            
            $wallet->increment('balance', $amount);

            
            return $this->recordTransaction(new RecordTransactionData(
                wallet: $wallet,
                amount: $amount,
                type: 'deposit',
                description: $description,
                transactionNumber: $transactionNumber
            ));
        });
    }

    /**
     * Withdraw from the wallet
     *
     * @param Model $walletable
     * @param float $amount
     * @param string|null $description
     * @return WalletTransaction
     */
    public function withdraw(Model $walletable, float $amount, ?string $description = null): WalletTransaction
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException(message: 'ليس لديه رصيد كافي للسحب.');
        }

        return DB::transaction(function () use ($walletable, $amount, $description) {
            $wallet = $this->getOrCreateWallet($walletable, true);

            $this->ensureSufficientBalance($wallet, $amount);
            $transactionNumber = $this->generateRandomTransactionNumber();

            
            $wallet->decrement('balance', $amount);

            
            return $this->recordTransaction(new RecordTransactionData(
                wallet: $wallet,
                amount: $amount,
                type: 'withdraw',
                description: $description,
                fromWalletId: $wallet->id,
                transactionNumber: $transactionNumber
            ));
        });
    }

    /**
     * Transfer between two wallets
     *
     * @param Model $fromWalletable
     * @param Model $toWalletable
     * @param float $amount
     * @param string|null $description
     * @param int|null $donationCaseId  
     * @return void
     */
    public function transfer(Model $fromWalletable, Model $toWalletable, float $amount, ?string $description = null, int $donationCaseId): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException('يجب أن يكون المبلغ أكبر من صفر.');
        }

        DB::transaction(function () use ($fromWalletable, $toWalletable, $amount, $description, $donationCaseId) {
            // Lock the wallets
            $fromWallet = $this->getOrCreateWallet($fromWalletable, true);
            $toWallet = $this->getOrCreateWallet($toWalletable, true);

            if ($fromWallet->id === $toWallet->id) {
                throw new RuntimeException('لا يمكن التحويل إلى نفس المحفظة.');
            }

            $this->ensureSufficientBalance($fromWallet, $amount);
            $transactionNumber = $this->generateRandomTransactionNumber();

            // withdraw from sender wallet
            $fromWallet->decrement('balance', $amount);
            $this->recordTransaction(new RecordTransactionData(
                wallet: $fromWallet,
                amount: $amount,
                type: 'withdraw',
                description: $description,
                toWalletId: $toWallet->id,
                fromWalletId: $fromWallet->id,
                donationCaseId: $donationCaseId,
                transactionNumber: $transactionNumber
            ));

            // deposit to receiver wallet
            $toWallet->increment('balance', $amount);
            $this->recordTransaction(new RecordTransactionData(
                wallet: $toWallet,
                amount: $amount,
                type: 'deposit',
                description: 'استقبال تبرع',
                toWalletId: $toWallet->id,
                fromWalletId: $fromWallet->id,
                donationCaseId: $donationCaseId,
                transactionNumber: $transactionNumber
            ));
        });
    }

    /**
     * Get wallet balance
     */
    public function balance(Model $walletable): float
    {
        return $walletable->wallet?->balance ?? 0;
    }

    /**
     * Get wallet or create it if it doesn't exist
     *
     * @param Model $walletable
     * @param bool $lock
     * @return Wallet
     */
    private function getOrCreateWallet(Model $walletable, bool $lock = false): Wallet
    {
        $query = $walletable->wallet(); // Polymorphic relationship
        $wallet = $lock ? $query->lockForUpdate()->first() : $query->first();

        return $wallet ?? $walletable->wallet()->create();
    }

    
    private function ensureSufficientBalance(Wallet $wallet, float $amount): void
    {
        if ($wallet->balance < $amount) {
            throw new RuntimeException('رصيدك غير كافٍ.');
        }
    }

    /**
     * Record wallet transaction using DTO
     */
    private function recordTransaction(RecordTransactionData $data): WalletTransaction
    {
        return WalletTransaction::create($data->toArray());
    }

    /**
     * Generate transaction number
     */
    private function generateRandomTransactionNumber(): string
    {
        $prefix = 'LY-';
        $number = null;

        while (!$number || WalletTransaction::where('transaction_number', $number)->exists()) {
            $number = $prefix . Str::upper(Str::random(10));
        }

        return $number;
    }
}