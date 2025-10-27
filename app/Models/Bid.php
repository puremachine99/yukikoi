<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'koi_id',
        'user_id',
        'amount',
        'is_win',
        'is_bin',
        'is_sniping',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_win' => 'boolean',
        'is_bin' => 'boolean',
        'is_sniping' => 'boolean',
    ];

    // Model Bid
    public function auction()
    {
        return $this->hasOneThrough(
            Auction::class,
            Koi::class,
            'id',
            'auction_code',
            'koi_id',
            'auction_code'
        );
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
