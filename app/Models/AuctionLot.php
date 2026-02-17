<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AuctionLot extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['auction_id', 'lot_code', 'title', 'open_bid', 'min_step', 'reserve_price', 'buy_now_price'];
    protected $casts = ['open_bid' => 'decimal:2', 'min_step' => 'decimal:2', 'reserve_price' => 'decimal:2', 'buy_now_price' => 'decimal:2'];

    protected static function booted(): void
    {
        static::creating(function (self $lot): void {
            if (empty($lot->{$lot->getKeyName()})) {
                $lot->{$lot->getKeyName()} = (string) Str::uuid();
            }
        });

        static::saving(function (self $lot): void {
            if (blank($lot->lot_code)) {
                $lot->lot_code = $lot->generateLotCode();
            }
        });
    }

    protected function generateLotCode(): string
    {
        if (! $this->auction_id) {
            return 'LOT-001';
        }

        $auction = $this->relationLoaded('auction')
            ? $this->auction
            : $this->auction()->with(['seller.profile'])->first();

        $baseName = optional(optional($auction)->seller->profile)->farm_name
            ?? optional(optional($auction)->seller)->name
            ?? 'LOT';

        $prefix = Str::upper(Str::slug($baseName, ''));

        if ($prefix === '') {
            $prefix = 'LOT';
        }

        $prefix = Str::limit($prefix, 12, '');

        /** @var Collection<int, int> $existingNumbers */
        $existingNumbers = static::query()
            ->where('auction_id', $this->auction_id)
            ->whereNotNull('lot_code')
            ->where('lot_code', 'like', $prefix . '-%')
            ->pluck('lot_code')
            ->map(function (string $code) use ($prefix): int {
                $number = (int) ltrim(Str::after($code, $prefix . '-'), '0');

                return $number > 0 ? $number : 0;
            });

        $sequence = ($existingNumbers->max() ?? 0) + 1;

        return sprintf('%s-%03d', $prefix, $sequence);
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function items()
    {
        return $this->belongsToMany(Item::class, 'lot_items', 'lot_id', 'item_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'lot_id');
    }

    public function room()
    {
        return $this->morphOne(Room::class, 'scope');
    }
}
