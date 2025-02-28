<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'koi',
            'koi.media' => function ($query) {
                $query->where('media_type', 'photo')->limit(1); // Ambil hanya foto pertama
            },
            'buyer'
        ])->where('seller_id', auth()->id())->get();

        return view('orders.index', compact('orders'));
    }


    public function updateStatus(Request $request, Order $order)
    {
        $order->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status pesanan berhasil diupdate.');
    }
}
