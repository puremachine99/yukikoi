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

        // Definisi tab status
        $tabs = [
            'semua' => 'Semua',
            'menunggu konfirmasi' => 'Menunggu Konfirmasi',
            'sedang dikemas' => 'Sedang Dikemas',
            'dikirim' => 'Dikirim',
            'selesai' => 'Selesai',
            'retur' => 'Retur'
        ];

        // Query pesanan berdasarkan status
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
            $ordersQuery->where('status', $status);
        }

        $orders = $ordersQuery->get();

        return view('orders.index', compact('orders', 'tabs', 'status'));
    }


    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:menunggu konfirmasi,sedang dikemas,dikirim'
        ]);

        // Pastikan hanya Seller yang bisa mengupdate status
        if (auth()->id() !== $order->seller_id) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengubah status pesanan ini.');
        }

        // Update status pesanan
        $order->update(['status' => $request->status]);

        // Cari transaction item terkait (kalau ada)
        $transactionItem = TransactionItem::where('transaction_id', $order->transaction_id)
            ->where('koi_id', $order->koi_id)
            ->first();

        // Simpan log perubahan status di StatusHistory
        StatusHistory::create([
            'order_id' => $order->id,
            'transaction_item_id' => $transactionItem?->id, // Simpan jika ada
            'status' => $request->status,
            'changed_by' => auth()->id(),
            'changed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

}
