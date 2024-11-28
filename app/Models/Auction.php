<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Bid;
use App\Models\Koi;
use App\Models\User;
use App\Events\ExtraTimeAdded;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Auction extends Model
{
    use HasFactory;
    protected $primaryKey = 'auction_code';
    public $incrementing = false; // Karena primary key-nya bukan integer
    protected $keyType = 'string';
    protected $fillable = [
        'title',
        'description',
        'jenis',
        'start_time',
        'end_time',
        'status',
        'auction_code',
        'banner',
        'user_id'
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

            // Hitung total lelang pada bulan dan tahun ini
            $count = Auction::whereYear('created_at', date('Y'))->whereMonth('created_at', date('m'))->count() + 1;

            do {
                // Generate auction_code
                $auctionCode = $prefix . $year . $month . str_pad($count, 3, '0', STR_PAD_LEFT);

                // Cek apakah auction_code sudah ada di database
                $exists = Auction::where('auction_code', $auctionCode)->exists();

                if ($exists) {
                    $count++; // Jika sudah ada, tambah nomor urutnya dan ulangi
                }
            } while ($exists);

            // Set auction_code jika belum ada bentrokan
            $auction->auction_code = $auctionCode;
        });
    }
    public function checkAndAddExtraTime()
    {
        $now = Carbon::now();
        $remainingTime = $this->end_time->diffInMinutes($now);

        // Jika waktu tersisa <= 10 menit dan ada bid, tambahkan 10 menit ke extra_time
        if ($this->status === 'on going' && $remainingTime <= 10) {
            // Hitung total waktu tersisa (end_time + extra_time)
            $totalTimeRemaining = $remainingTime + $this->extra_time;

            if ($totalTimeRemaining <= 10) {
                // Tambahkan 10 menit ke extra_time
                $this->extra_time += 10;
                $this->save();

                // Broadcast pesan admin tentang extra time di chat
                event(new ExtraTimeAdded($this, 10));  // 10 menit tambahan waktu
            }
        }
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Koi (satu lelang punya banyak koi)
    public function koi()
    {
        return $this->hasMany(Koi::class, 'auction_code', 'auction_code');
    }

    // Relasi ke Bid (satu lelang punya banyak bid)
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'auction_code', 'auction_code');
    }
}
