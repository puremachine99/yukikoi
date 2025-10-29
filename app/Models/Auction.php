<?php

namespace App\Models;

use App\Models\Bid;
use App\Models\Koi;
use App\Models\User;
use App\Events\ExtraTimeAdded;
use App\Support\AuctionCodeGenerator;
use Carbon\Carbon;
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
        'extra_time',
        'auction_code',
        'banner',
        'user_id'
    ];
    protected $appends = ['banner_url'];
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'created_at' => 'datetime',
        'extra_time' => 'integer',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $auction) {
            if ($auction->auction_code) {
                return;
            }

            $generator = app(AuctionCodeGenerator::class);
            $auction->auction_code = $generator->generate($auction->jenis);
        });
    }
    public function checkAndAddExtraTime(): void
    {
        if (!$this->end_time instanceof Carbon) {
            return;
        }

        $now = Carbon::now();
        $remainingTime = $this->end_time->diffInMinutes($now);

        if ($this->status !== 'on going' || $remainingTime > 10) {
            return;
        }

        $totalTimeRemaining = $remainingTime + (int) $this->extra_time;

        if ($totalTimeRemaining > 10) {
            return;
        }

        $this->extra_time = (int) $this->extra_time + 10;
        $this->save();

        $newEndTime = $this->end_time->copy()->addMinutes($this->extra_time)->toDateTimeString();

        event(new ExtraTimeAdded(
            $this->auction_code,
            (int) $this->extra_time,
            $newEndTime,
            10
        ));
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

    public function getBannerUrlAttribute(): string
    {
        return \App\Support\Media::url($this->banner, [
            'resize' => ['fill', 1200, 600, 1],
        ]);
    }

}
