<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;


class WalletTransaction extends Model
{
    protected $fillable = [
        'amount',
        'type',
        'description',
        'wallet_id',
        'transaction_number',
        'from_wallet_id',
        'to_wallet_id',
        'donation_case_id'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function fromWallet()
    {
        return $this->belongsTo(Wallet::class, 'from_wallet_id');
    }

    public function toWallet()
    {
        return $this->belongsTo(Wallet::class, 'to_wallet_id');
    }

    public function donationCase()
    {
        return $this->belongsTo(DonationCase::class, 'donation_case_id');
    }

    public function scopeFilter(Builder | QueryBuilder $query, array $filters)
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {

                $query->where('transaction_number', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")

                    ->orWhereHas('wallet.walletable', function ($q) use ($search) {
                        $q->where('fullName', 'like', "%{$search}%");
                    })

                    ->orWhereHas('fromWallet.walletable', function ($q) use ($search) {
                        $q->where('fullName', 'like', "%{$search}%");
                    })

                    ->orWhereHas('toWallet.walletable', function ($q) use ($search) {
                        $q->where('fullName', 'like', "%{$search}%");
                    });
            });
        });
    }
}
