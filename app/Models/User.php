<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'farm_name',
        'address',
        'city',
        'phone_number',
        'nik',
        'profile_photo',
        'is_seller',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class);
    }

    // Relasi ke Bid (user bisa punya banyak bid)
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }
    
    public function markedKois()
    {
        return $this->belongsToMany(Koi::class, 'marked_kois')->withTimestamps();
    }
}