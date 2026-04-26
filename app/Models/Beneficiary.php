<?php

namespace App\Models;

use App\Models\Traits\HasWallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Beneficiary extends Model
{
    use HasFactory, HasWallet;

        protected $fillable = [
            'fullName',
            'surname',
            'ssn',
            'date_of_birth',
            'place_of_birth',
            'address',
            'phone_number',
            'notes',
            'personal_photo_path',
            'bank_statement_photo_path'
        ];


        public function hasBalance(): bool
        {
            return $this->wallet && $this->wallet->balance > 0;
        }

        public function hasActiveCase(): bool{
                return $this->donationCases()
                    ->where('status', 'active')
                    ->exists();
        }

        public function donationCases()
        {
            return $this->hasMany(DonationCase::class);
        }

        public function scopeFilter(Builder | QueryBuilder $query, array $filters){

            return $query->when($filters['search'] ?? null, function($query, $search){
                $query->where(function($query) use ($search){
                    $query->where('fullName', 'like', '%'.$search.'%')
                    ->orWhere('ssn', 'like', '%'.$search.'%');
                    });
            });
            
        }


    
}
