<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['lot_id', 'user_id', 'amount', 'is_sniping', 'created_at'];
    protected $casts = ['amount' => 'decimal:2', 'is_sniping' => 'boolean', 'created_at' => 'datetime'];

    public function lot()
    {
        return $this->belongsTo(AuctionLot::class, 'lot_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
