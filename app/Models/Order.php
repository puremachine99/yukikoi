<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'buyer_id',
        'seller_id',
        'koi_id',
        'transaction_id',
        'total_price',
        'status',
        'shipping_address',
        'recipient_name',
        'recipient_phone',
        'shipping_group',
        'tracking_number',
    ];

    public function koi()
    {
        return $this->belongsTo(Koi::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class, 'order_id', 'id');
    }

    // app/Models/Order.php
    public function statusHistories()
    {
        return $this->hasMany(StatusHistory::class, 'order_id')->orderBy('changed_at', 'desc');
    }

}
