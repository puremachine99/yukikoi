<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionReport extends Model
{
    protected $primaryKey = 'auction_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['auction_id', 'stats', 'generated_at'];
    protected $casts = ['stats' => 'array', 'generated_at' => 'datetime'];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }
}
