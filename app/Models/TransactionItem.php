<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = [
        'transaction_id',
        'koi_id',
        'farm',
        'price',
        'shipping_fee',
        'shipping_group',
        'farm_owner_name',
        'farm_phone_number',
        'shipping_address',
        'status',
        'karantina_reason',
        'karantina_end_date',
        'cancel_reason',
    ];

    public function koi()
    {
        return $this->belongsTo(Koi::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(StatusHistory::class, 'transaction_item_id')->orderBy('changed_at', 'desc');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'transaction_item_id');
    }

    
}

