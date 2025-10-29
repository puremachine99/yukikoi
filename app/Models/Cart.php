<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function koi(): BelongsTo
    {
        return $this->belongsTo(Koi::class, 'koi_id', 'id');
    }

    public function auction(): BelongsTo
    {
        return $this->belongsTo(Auction::class, 'auction_code', 'auction_code');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    protected function auctionCode(): Attribute
    {
        return Attribute::get(function ($value, array $attributes) {
            if (!empty($value)) {
                return $value;
            }

            if ($this->relationLoaded('koi')) {
                $code = $this->koi?->auction_code;
                if ($code !== null) {
                    $this->attributes['auction_code'] = $code;
                }

                return $code;
            }

            if (empty($this->koi_id)) {
                return null;
            }

            $code = Koi::query()
                ->where('id', $this->koi_id)
                ->value('auction_code');

            if ($code !== null) {
                $this->attributes['auction_code'] = $code;
            }

            return $code;
        });
    }

    protected function sellerId(): Attribute
    {
        return Attribute::get(function ($value) {
            if (!empty($value)) {
                return $value;
            }

            if ($this->relationLoaded('koi')) {
                $auction = $this->koi?->relationLoaded('auction')
                    ? $this->koi?->auction
                    : $this->koi?->auction()->first();

                $sellerId = $auction?->user_id;

                if ($sellerId !== null) {
                    $this->attributes['seller_id'] = $sellerId;
                }

                return $sellerId;
            }

            if (empty($this->koi_id)) {
                return null;
            }

            $sellerId = Koi::query()
                ->where('id', $this->koi_id)
                ->join('auctions', 'auctions.auction_code', '=', 'kois.auction_code')
                ->value('auctions.user_id');

            if ($sellerId !== null) {
                $this->attributes['seller_id'] = $sellerId;
            }

            return $sellerId;
        });
    }
}

