<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder as QueryBuilder;

class DonationCase extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
            'beneficiary_id',
            'title',
            'description',
            'target_amount',
            'current_amount',
            'status',
            'type',
            'img_url',
        ];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class, 'donation_case_id');
    }

    public function scopeFilter(Builder | QueryBuilder $query, array $filters){

        return $query->when($filters['search'] ?? null, function($query, $search){
            $query->where(function($query) use ($search){
                $query->where('title', 'like', '%'.$search.'%')
                      ->orWhere('id', 'like', '%'.$search.'%');
            });
        });
            
    }
}
