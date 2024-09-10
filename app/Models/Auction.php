<?php

namespace App\Models;

use App\Models\Bid;
use App\Models\Koi;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auction extends Model
{
    use HasFactory;
    protected $fillable = [
       'title', 'description', 'jenis', 'start_time', 'end_time', 'status', 'auction_code', 'banner', 'user_id'
    ];
    protected $casts = [
        'start_time' => 'datetime',
        'created_at' => 'datetime',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($auction) {
            // Tentukan prefix berdasarkan jenis lelang
            $prefix = match ($auction->jenis) {
                'azukari' => 'AZ',
                'keeping_contest' => 'KC',
                'grow_out' => 'GO',
                default => 'RG', // Default untuk reguler
            };

            $year = date('y');
            $month = date('m');
            $count = Auction::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count() + 1;
            $auction->auction_code = $prefix . $year . $month . str_pad($count, 3, '0', STR_PAD_LEFT);
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Koi (satu lelang punya banyak koi)
    public function koi()
    {
        return $this->hasMany(Koi::class);
    }

    // Relasi ke Bid (satu lelang punya banyak bid)
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}
