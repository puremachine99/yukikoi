<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasUuids;
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'owner_id',
        'species_id',
        'title',
        'description',
        'gender',
        'size_cm',
        'open_bid',
        'bid_step',
        'buy_now_price',
        'media',
        'status',
        'sku'
    ];
    protected $casts = ['media' => 'array', 'size_cm' => 'decimal:2', 'open_bid' => 'decimal:2', 'bid_step' => 'decimal:2', 'buy_now_price' => 'decimal:2'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function species()
    {
        return $this->belongsTo(FishSpecies::class, 'species_id');
    }
    public function lots()
    {
        return $this->belongsToMany(AuctionLot::class, 'lot_items', 'item_id', 'lot_id');
    }
    public function likes()
    {
        return $this->belongsToMany(User::class, 'item_likes', 'item_id', 'user_id');
    }
    public function shares()
    {
        return $this->hasMany(ItemShare::class);
    }
}
