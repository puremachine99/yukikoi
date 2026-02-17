<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['order_id', 'lot_id', 'item_id', 'qty', 'price', 'fee'];
    protected $casts = ['price' => 'decimal:2', 'fee' => 'decimal:2'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function lot()
    {
        return $this->belongsTo(AuctionLot::class, 'lot_id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
