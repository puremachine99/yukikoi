<?php
// app/Http/Controllers/WhatsAppController.php
namespace App\Http\Controllers;

use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use App\Models\PasswordResetOtp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{
    public function sendTestMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|min:3|max:255'
        ]);

        $phoneInput = trim($request->phone_number ?? '');
        if ($phoneInput === '') {
            $numbers = User::whereNotNull('phone_number')->pluck('phone_number')->toArray();
        } else {
            $numbers = array_filter(array_map('trim', explode(',', $phoneInput)));
        }

        $success = [];
        $failed = [];
        foreach ($numbers as $idx => $phoneNumber) {
            $phoneNumber = $this->normalizePhoneNumber($phoneNumber); // Normalize here
            $originalMessage = $request->message;
            $signature = env('WA_SIGNATURE', "\n\n-- Yukikoi Bot");
            $finalMessage = $originalMessage . $signature;
            $botUrl = config('app.whatsapp_bot_url') . '/send-message';
            Log::channel('whatsapp')->info('Mengirim pesan WhatsApp', [
                'action' => 'send_message',
                'phone' => $phoneNumber,
                'message' => $finalMessage,
                'bot_url' => $botUrl
            ]);
            try {
                $response = Http::timeout(15)
                    ->retry(3, 500)
                    ->withHeaders([
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'X-Request-From' => 'laravel-app'
                    ])
                    ->post($botUrl, [
                        'phone_number' => $phoneNumber,
                        'message' => $finalMessage
                    ]);
                $responseData = $response->json();
                if ($response->successful()) {
                    Log::channel('whatsapp')->info('Pesan terkirim', [
                        'status' => 'success',
                        'message_id' => $responseData['message_id'] ?? null,
                        'response' => $responseData
                    ]);
                    $success[] = $phoneNumber;
                } else {
                    Log::channel('whatsapp')->warning('Bot merespons error', [
                        'status_code' => $response->status(),
                        'response' => $responseData
                    ]);
                    $failed[] = $phoneNumber;
                }
            } catch (\Exception $e) {
                Log::channel('whatsapp')->error('Gagal mengirim pesan', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                $failed[] = $phoneNumber;
            }
            if ($idx < count($numbers) - 1) {
                sleep(2); // Delay 2 detik antar nomor
            }
        }
        $msg = '';
        if ($success) {
            $msg .= 'Berhasil dikirim ke: ' . implode(', ', $success) . '. ';
        }
        if ($failed) {
            $msg .= 'Gagal dikirim ke: ' . implode(', ', $failed) . '.';
        }
        return back()->with('success', $msg);
    }
    // app/Http/Controllers/WhatsAppController.php
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string'
        ]);

        // Normalisasi nomor telepon
        $rawPhone = $request->phone_number;
        $normalizedPhone = $this->normalizePhoneNumber($rawPhone);

        // Cek user dengan nomor yang sudah dinormalisasi
        $user = User::where('phone_number', $normalizedPhone)
            ->orWhere('phone_number', $rawPhone)
            ->first();

        if (!$user) {
            return back()->with('error', 'Nomor tidak terdaftar');
        }

        // Update nomor di database ke format standar jika belum
        if ($user->phone_number !== $normalizedPhone) {
            $user->update(['phone_number' => $normalizedPhone]);
        }

        $otpService = new OtpService();
        $result = $otpService->generateOtp($normalizedPhone);

        $message = "Kode OTP Anda: *{$result['otp']}*\n" .
            "Berlaku hingga: {$result['expires_at']->format('H:i')}\n\n" .
            "Jangan berikan kode ini kepada siapapun.\n";

        return $this->sendTestMessage(new Request([
            'phone_number' => $normalizedPhone,
            'message' => $message
        ]));
    }

    private function normalizePhoneNumber($phone)
    {
        // Hapus semua karakter non-digit
        $phone = preg_replace('/\D/', '', $phone);

        // Jika diawali 0, ganti dengan 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // Jika diawali +62, hapus +
        if (substr($phone, 0, 3) === '+62') {
            $phone = '62' . substr($phone, 3);
        }

        return $phone;
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'otp' => 'required|digits:6'
        ]);

        $otpRecord = PasswordResetOtp::where('phone_number', $request->phone_number)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return back()->with('error', 'OTP tidak valid atau sudah kadaluarsa');
        }

        $otpRecord->update(['verified' => true]);

        return back()->with('success', 'OTP berhasil diverifikasi');
    }
}