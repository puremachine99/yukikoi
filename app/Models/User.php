<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    // // Role constant biar ceknya enak
    // const ROLE_GUEST = 'guest';
    // const ROLE_BIDDER = 'bidder';
    // const ROLE_SELLER = 'seller';
    // const ROLE_PRIORITY_SELLER = 'priority_seller';
    // const ROLE_ADMIN = 'admin';

    // // Verifikasi role pengguna
    // public function isRole($role)
    // {
    //     return $this->role === $role;
    // }

    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'instagram',
        'youtube',
        'password',
        'farm_name',
        'address',
        'city',
        'phone_number',
        'nik',
        'profile_photo',
        'is_seller',
        'bio',
        'google_id',
        'google_avatar',
        'google_token',
        'google_refresh_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google_token',
        'google_refresh_token',
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

    public function embers()
    {
        return $this->belongsToMany(Koi::class, 'marked_kois')->withTimestamps();
    }

    // follow dan follower
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }

    // ambil user2 yang di follow kamu
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
    }

    // cek user follow user lain gak?
    public function isFollowing($userId)
    {
        return $this->followings()->where('following_id', $userId)->exists();
    }

    // Cek jika user difollow orang lain
    public function isFollowedBy($userId)
    {
        return $this->followers()->where('follower_id', $userId)->exists();
    }

    public function isPrioritySeller()
    {
        return $this->is_priority_seller && $this->subscription_end > now();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements');
    }

    // Seller menerima rating dari buyer
    public function ratingsReceived()
    {
        return $this->hasMany(Rating::class, 'seller_id', 'id');
    }

    // Buyer memberikan rating ke seller
    public function ratingsGiven()
    {
        return $this->hasMany(Rating::class, 'buyer_id', 'id');
    }

    public function getOverallRatingAttribute()
    {
        return $this->ratingsReceived()
            ->selectRaw('(AVG(rating_quality) + AVG(rating_shipping) + AVG(rating_service)) / 3 as avg')
            ->pluck('avg')
            ->first() ?? 0;
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'seller_id');
    }
    // Menghitung rata-rata rating berdasarkan semua transaksi
    public function averageRating()
    {
        return $this->ratingsReceived()
            ->selectRaw('seller_id, 
                     AVG(rating_quality) as avg_quality, 
                     AVG(rating_shipping) as avg_shipping, 
                     AVG(rating_service) as avg_service, 
                     (AVG(rating_quality) + AVG(rating_shipping) + AVG(rating_service)) / 3 as overall_rating')
            ->groupBy('seller_id');
    }

    public function checkAndAssignAchievements()
    {
        $achievements = Achievement::all();
        foreach ($achievements as $achievement) {
            // Evaluasi condition
            if ($this->evaluateAchievementCondition($achievement->condition)) {
                // Tambahkan achievement ke user
                $this->achievements()->syncWithoutDetaching([$achievement->id]);
            }
        }
    }

    protected function evaluateAchievementCondition($condition)
    {
        // Contoh parsing condition (gunakan eval untuk hal simpel, atau buat parser sendiri untuk complex)
        return eval ("return {$condition};");
    }
}
