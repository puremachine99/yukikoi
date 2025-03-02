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
        'farm',
        'farm_owner_name',
        'farm_phone_number',
        'shipping_address',
        'status',
    ];
    public function getStatusAttribute()
    {
        return $this->attributes['status']; // Ambil langsung dari database
    }


    public function koi()
    {
        return $this->belongsTo(Koi::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    // app/Models/TransactionItem.php
    public function statusHistories()
    {
        return $this->hasMany(StatusHistory::class, 'transaction_item_id')->orderBy('changed_at', 'desc');
    }

}
