<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionCounter extends Model
{
    protected $fillable = [
        'prefix',
        'year',
        'month',
        'sequence',
    ];
}
