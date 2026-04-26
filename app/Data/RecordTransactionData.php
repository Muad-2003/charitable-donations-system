<?php

namespace App\Data;

use Illuminate\Database\Eloquent\Model;

class RecordTransactionData
{
    public function __construct(
        public Model $wallet,
        public float $amount,
        public string $type,
        public ?string $description = null,
        public ?int $toWalletId = null,
        public ?int $fromWalletId = null,
        public ?int $donationCaseId = null,
        public ?string $transactionNumber = null,
    ) {}

    public function toArray(): array
    {
        return [
            'wallet_id'          => $this->wallet->id,
            'type'               => $this->type,
            'amount'             => $this->amount,
            'description'        => $this->description,
            'to_wallet_id'       => $this->toWalletId,
            'from_wallet_id'     => $this->fromWalletId,
            'donation_case_id'   => $this->donationCaseId,
            'transaction_number' => $this->transactionNumber
        ];
    }
}
