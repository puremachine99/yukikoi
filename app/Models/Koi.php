<?php

namespace App\Models;

use App\Models\Ember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Koi extends Model
{
    use HasFactory;

    // Disable auto-incrementing because 'id' is custom
    public $incrementing = false;

    // Set the primary key type as 'string'
    protected $keyType = 'string';

    protected $fillable = [
        'id', // Custom ID generated from auction_code + kode_ikan
        'auction_code', // Foreign key dari Auction
        'kode_ikan', // Kode ikan (e.g., A, B, etc.)
        'judul',
        'jenis_koi', // Jenis Koi
        'ukuran', // Ukuran koi
        'gender', // Gender of the koi
        'open_bid', // Open bid
        'kelipatan_bid', // Increment bid
        'buy_it_now', // Buy it now price (nullable)
        'keterangan', // Description (optional)
        'breeder', // Breeder info (optional)
    ];

    // Model Koi
    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_code', 'auction_code');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'koi_id', 'id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'koi_id', 'id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'koi_id', 'id');
    }

    public function ember()
    {
        return $this->belongsToMany(Ember::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'koi_id');
    }

    public function activities()
    {
        return $this->hasMany(UserActivity::class, 'koi_id', 'id');
    }
}
