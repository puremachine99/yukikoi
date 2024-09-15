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

    // Relationship to Auction
    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_code', 'auction_code');
    }

    // Relationship to Media
    public function media()
    {
        return $this->hasMany(Media::class, 'koi_id', 'id');
    }

    // Relationship to Certificates
    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'koi_id', 'id');
    }

    public function bid()
    {
        return $this->hasMany(Bid::class, 'koi_id', 'user_id');
    }

    public function ember()
    {
        return $this->belongsToMany(Ember::class);
    }
}
