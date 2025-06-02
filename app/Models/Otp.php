<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone_number',
        'otp',
        'purpose',
        'verified',
        'expires_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'verified' => 'boolean',
        'expires_at' => 'datetime'
    ];

    /**
     * Scope for valid OTPs (not expired and not verified)
     */
    public function scopeValid($query)
    {
        return $query->where('verified', false)
                    ->where('expires_at', '>', now());
    }

    /**
     * Scope for specific purpose
     */
    public function scopeForPurpose($query, $purpose)
    {
        return $query->where('purpose', $purpose);
    }

    /**
     * Mark OTP as verified
     */
    public function markAsVerified()
    {
        $this->update(['verified' => true]);
        return $this;
    }

    /**
     * Check if OTP matches
     */
    public function matches($otp): bool
    {
        return hash_equals($this->otp, hash('sha256', $otp));
    }
}