<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_item_id',
        'order_id',
        'buyer_id',
        'seller_id',
        'type', // retur atau komplain
        'reason',
        'proof',
        'status' // pending, disetujui, ditolak
    ];

    // Relasi ke transaction item
    public function transactionItem()
    {
        return $this->belongsTo(TransactionItem::class);
    }

    // Relasi ke order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke buyer (user yang mengajukan komplain/retur)
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    // Relasi ke seller (user yang menerima komplain/retur)
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
