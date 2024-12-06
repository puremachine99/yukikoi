<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'koi_id',
        'activity_type',
        'weight',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'weight' => 'decimal:2',
    ];

    /**
     * Relasi ke tabel User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke tabel Koi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function koi()
    {
        return $this->belongsTo(Koi::class);
    }

    /**
     * Scope untuk filter aktivitas berdasarkan tipe.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('activity_type', $type);
    }

    /**
     * Scope untuk aktivitas user tertentu.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk aktivitas pada koi tertentu.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $koiId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForKoi($query, $koiId)
    {
        return $query->where('koi_id', $koiId);
    }
}
