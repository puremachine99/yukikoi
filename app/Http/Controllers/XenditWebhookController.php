<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Events\PaymentCompleted;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Log seluruh data yang diterima untuk debugging
        Log::info('Payload webhook diterima:', $request->all());

        // Ambil semua data dari request
        $data = $request->all();

        // Pastikan status pembayaran adalah "PAID" dan external_id tersedia
        if (isset($data['status']) && $data['status'] === 'PAID' && isset($data['external_id'])) {

            // Cari transaksi berdasarkan external_id
            $transaction = Transaction::where('external_id', $data['external_id'])->first();

            if ($transaction) {
                // Update status transaksi menjadi 'completed'
                $transaction->status = 'completed';
                $transaction->paid_at = now();
                $transaction->save();

                // Log keberhasilan update
                Log::info("Transaksi dengan ID {$transaction->id} berhasil diperbarui menjadi 'completed'.");

                // Broadcast notifikasi real-time hanya ke user yang melakukan transaksi
                broadcast(new PaymentCompleted($transaction))->toOthers();

                return response()->json(['message' => 'Transaksi berhasil diperbarui'], 200);
            } else {
                // Log jika transaksi tidak ditemukan
                Log::warning("Transaksi dengan external_id {$data['external_id']} tidak ditemukan.");
                return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
            }
        } else {
            // Log jika status bukan "PAID" atau external_id tidak ada
            Log::info("Status pembayaran bukan 'PAID' atau 'external_id' tidak ada, tidak ada tindakan yang diambil.");
            return response()->json(['message' => 'Tidak ada tindakan yang diambil'], 400);
        }
    }
}
