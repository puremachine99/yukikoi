<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

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
    $ordersQuery = Order::with(['koi.media', 'buyer'])
        ->where('seller_id', $sellerId);

    if ($status !== 'semua') {
        $ordersQuery->where('status', $status);
    }

    $orders = $ordersQuery->get();

    return view('orders.index', compact('orders', 'tabs', 'status'));
}


    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:menunggu konfirmasi,sedang dikemas,dikirim,selesai,dibatalkan'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diupdate.');
    }


}
