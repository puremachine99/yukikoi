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
        'id',
        'auction_code',
        'event_id', // Tambahkan event_id
        'kode_ikan',
        'judul',
        'jenis_koi',
        'ukuran',
        'gender',
        'open_bid',
        'kelipatan_bid',
        'buy_it_now',
        'keterangan',
        'breeder',
    ];
    
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
    

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
