<?php
// app/Http/Controllers/WhatsAppController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppController extends Controller
{
    public function sendTestMessage(Request $request)
    {
        $request->validate(['message' => 'required|string']);

        $botUrl = config('app.whatsapp_bot_url') . '/send-message';

        \Log::info("Attempting to send to bot", [
            'url' => $botUrl,
            'payload' => [
                'phone_number' => '6282257111684', // Nomor dummy
                'message' => $request->message
            ]
        ]);

        try {
            $response = Http::timeout(15)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ])
                ->post($botUrl, [
                    'phone_number' => '6282257111684',
                    'message' => $request->message
                ]);

            \Log::debug("Bot response", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Pesan dikirim!');
            }

            return back()->with('error', 'Bot response error: ' . $response->body());

        } catch (\Exception $e) {
            \Log::error("Bot connection failed", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Gagal terhubung ke bot');
        }
    }
}