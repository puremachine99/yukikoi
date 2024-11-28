<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'koi_id',
        'user_id',
        'amount',
        'is_winner'
    ];

    // Model Bid
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function koi()
    {
        return $this->belongsTo(Koi::class, 'koi_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
