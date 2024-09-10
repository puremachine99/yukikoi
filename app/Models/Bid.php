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
        'bid_amount',
        'is_winner'
    ];

    // Relasi ke Auction
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    // Relasi ke Koi
    public function koi()
    {
        return $this->belongsTo(Koi::class);
    }

    // Relasi ke User (bidder)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
