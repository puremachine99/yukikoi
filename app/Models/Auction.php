<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'seller_id',
        'title',
        'description',
        'type',
        'status',
        'start_at',
        'end_at',
        'anti_snipe_window_sec',
        'extend_step_sec',
        'buy_now_price',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'buy_now_price' => 'decimal:2',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function lots()
    {
        return $this->hasMany(AuctionLot::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function bids()
    {
        return $this->hasManyThrough(Bid::class, AuctionLot::class, 'auction_id', 'lot_id');
    }

    public function report()
    {
        return $this->hasOne(AuctionReport::class);
    }

    public function room()
    {
        return $this->morphOne(Room::class, 'scope');
    }
}
