<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'transaction_item_id',
        'buyer_id',
        'seller_id',
        'type', // retur atau komplain
        'reason',
        'proof',
        'status' // pending, disetujui, ditolak
    ];

    public function transactionItem()
    {
        return $this->belongsTo(TransactionItem::class, 'transaction_item_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}

