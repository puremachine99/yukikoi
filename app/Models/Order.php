<?php

namespace App\Models;

use App\Models\EscrowEntry;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['buyer_id', 'seller_id', 'auction_id', 'status', 'subtotal', 'fee_total', 'total', 'expires_at'];
    protected $casts = ['subtotal' => 'decimal:2', 'fee_total' => 'decimal:2', 'total' => 'decimal:2', 'expires_at' => 'datetime'];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function escrowEntries()
    {
        return $this->hasMany(EscrowEntry::class);
    }
}
