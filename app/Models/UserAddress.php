<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recipient_name',
        'phone_number',
        'full_address',
        'city',
        'district',
        'type',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
