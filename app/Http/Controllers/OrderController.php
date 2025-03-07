<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\StatusHistory;
use App\Models\TransactionItem;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = auth()->id();
        $status = $request->query('status', 'semua');

        // Daftar tab status
        $tabs = [
            'semua' => 'Semua',
            'menunggu konfirmasi' => 'Konfirmasi',
            'karantina' => 'Karantina',
            'siap dikirim' => 'Siap Dikirim',
            'dikirim' => 'Dikirim',
            'selesai' => 'Selesai',
            'proses pengajuan komplain' => 'Komplain',
            'dibatalkan' => 'Dibatalkan',
        ];

        // Query pesanan berdasarkan status
        $ordersQuery = Order::with([
            'koi' => function ($query) {
                $query->with([
                    'media' => function ($mediaQuery) {
                        $mediaQuery->where('media_type', 'photo')->limit(1);
                    }
                ]);
            },
            'buyer'
        ])->where('seller_id', $sellerId);

        if ($status !== 'semua') {
            if ($status === 'komplain') {
                // Jika tab "Komplain" dipilih, ambil semua status terkait komplain
                $ordersQuery->whereIn('status', [
                    'proses pengajuan komplain',
                    'komplain disetujui',
                    'komplain ditolak'
                ]);
            } else {
                // Status biasa
                $ordersQuery->where('status', $status);
            }
        }

        $orders = $ordersQuery->get();


        return view('orders.index', compact('orders', 'tabs', 'status'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:siap dikirim,dikirim,karantina,dibatalkan',
            'reason' => 'nullable|string|max:255',
            'karantina_end_date' => 'nullable|date|after:today'
        ]);

        // Pastikan hanya seller yang bisa update status
        if (auth()->id() !== $order->seller_id) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengubah status pesanan ini.');
        }

        // Jika status karantina, pastikan ada alasan dan tentukan tanggal akhir karantina
        $karantinaEndDate = null;
        if ($request->status === 'karantina') {
            if (!$request->reason) {
                return redirect()->back()->with('error', 'Alasan karantina harus diisi.');
            }

            $karantinaEndDate = now();
            if ($request->reason === 'Ikan Sakit (7 hari)') {
                $karantinaEndDate->addDays(7);
            } elseif ($request->reason === 'Ikan Buang Kotoran (3 hari)') {
                $karantinaEndDate->addDays(3);
            }
        }

        // Jika status dibatalkan, pastikan ada alasan
        if ($request->status === 'dibatalkan' && !$request->reason) {
            return redirect()->back()->with('error', 'Alasan pembatalan harus diisi.');
        }

        // Update status pesanan
        $order->update([
            'status' => $request->status,
            'karantina_reason' => $request->status === 'karantina' ? $request->reason : null,
            'karantina_end_date' => $karantinaEndDate,
            'cancel_reason' => $request->status === 'dibatalkan' ? $request->reason : null
        ]);

        // Update status di transaction_items
        $transactionItem = TransactionItem::where('transaction_id', $order->transaction_id)
            ->where('koi_id', $order->koi_id)
            ->first();

        if ($transactionItem) {
            $transactionItem->update(['status' => $request->status]);
        }

        // Simpan log perubahan status di StatusHistory
        StatusHistory::create([
            'order_id' => $order->id,
            'transaction_item_id' => $transactionItem?->id,
            'status' => $request->status,
            'changed_by' => auth()->id(),
            'changed_at' => now(),
            'reason' => $request->reason
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }



}
