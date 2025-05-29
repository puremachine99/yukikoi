<?php 
namespace App\Services;

use App\Models\PasswordResetOtp;
use App\Models\User;
use Carbon\Carbon;

class OtpService
{
    public function generateOtp($phoneNumber)
    {
        // Check if user exists
        $user = User::where('phone_number', $phoneNumber)->first();
        if (!$user) {
            return ['success' => false, 'message' => 'Nomor tidak terdaftar'];
        }

        // Generate 6-digit OTP
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = Carbon::now()->addMinutes(15);

        // Store OTP
        PasswordResetOtp::updateOrCreate(
            ['phone_number' => $phoneNumber],
            ['otp' => $otp, 'expires_at' => $expiresAt, 'verified' => false]
        );

        return [
            'success' => true,
            'otp' => $otp,
            'expires_at' => $expiresAt,
            'user' => $user
        ];
    }
}