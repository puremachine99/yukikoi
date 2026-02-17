<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['user_id', 'lot_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function lot()
    {
        return $this->belongsTo(AuctionLot::class, 'lot_id');
    }
}
