<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_item_id',
        'buyer_id',
        'seller_id',
        'rating',
        'review'
    ];

    public function rating()
    {
        return $this->hasOne(Rating::class, 'transaction_item_id', 'id');
    }

}
