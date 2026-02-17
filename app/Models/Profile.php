<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'user_id',
        'username',
        'display_name',
        'avatar_url',
        'banner_url',
        'farm_name',
        'address',
        'bio',
        'social_links',
        'public',
    ];
    protected $casts = [
        'social_links' => 'array',
        'public' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
