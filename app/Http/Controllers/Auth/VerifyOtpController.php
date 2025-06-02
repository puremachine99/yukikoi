<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\Request;

class VerifyOtpController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function showVerifyForm()
    {
        if (!session('phone_number')) {
            return redirect()->route('password.request')
                ->with('error', 'Silakan request OTP terlebih dahulu');
        }

        return view('auth.verify-otp', [
            'phone_number' => session('phone_number'),
            'purpose' => session('purpose')
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'otp' => 'required|digits:6',
            'purpose' => 'required|in:password_reset,registration'
        ]);

        if (!$this->otpService->verifyOtp(
            $request->phone_number,
            $request->otp,
            $request->purpose
        )) {
            return back()->with('error', 'Kode OTP tidak valid atau sudah kadaluarsa');
        }

        // Handle successful verification
        session()->put('otp_verified', true);

        return $request->purpose === 'password_reset'
            ? redirect()->route('password.reset')
            : redirect()->route('register.complete');
    }
}