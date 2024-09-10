<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Koi extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id',
        'kode_ikan',
        'jenis_koi',
        'ukuran',
        'gender',
        'open_bid',
        'kelipatan_bid',
        'buy_it_now'
    ];


    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
    public function media()
    {
        return $this->hasMany(Media::class);
    }
    public function markedByUsers()
    {
        return $this->belongsToMany(User::class, 'marked_kois')->withTimestamps();
    }
}
