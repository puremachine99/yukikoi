<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\TransactionItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Simpan Komplain atau Retur
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'item_id' => 'required|exists:transaction_items,id',
                'type' => 'required|in:retur,komplain',
                'reason' => 'required|string|min:5',
                'proof' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:51200'
            ]);

            // Ambil transaction item
            $transactionItem = TransactionItem::with('order')->findOrFail($request->item_id);
            $order = $transactionItem->order ?? Order::where('transaction_id', $transactionItem->transaction_id)->first();

            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Order tidak ditemukan!'], 400);
            }

            // Pastikan seller_id ditemukan
            $sellerId = $order->seller_id ?? $transactionItem->koi->auction->user_id ?? null;
            if (!$sellerId) {
                return response()->json(['success' => false, 'message' => 'Seller ID tidak ditemukan!'], 400);
            }

            // Simpan file bukti
            $proofPath = $request->file('proof')->store('complaints', 'public');

            // Simpan ke database
            Complaint::create([
                'transaction_item_id' => $request->item_id,
                'order_id' => $order->id,
                'buyer_id' => auth()->id(),
                'seller_id' => $sellerId,
                'type' => $request->type,
                'reason' => $request->reason,
                'proof' => $proofPath,
                'status' => 'pending',
            ]);

            // Update status order ke "dalam sengketa"
            $order->update(['status' => 'proses pengajuan komplain']);

            return response()->json(['success' => true, 'message' => 'Komplain berhasil dikirim!']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Lihat daftar komplain yang masuk untuk admin & seller
     */
    public function index()
    {
        $complaints = Complaint::with(['buyer', 'seller', 'transactionItem.koi'])
            ->where('seller_id', auth()->id()) // Seller hanya bisa melihat komplain yang terkait dengan mereka
            ->orWhereNull('seller_id') // Admin melihat semua komplain
            ->orderBy('created_at', 'desc')
            ->get();

        return view('complaints.index', compact('complaints'));
    }

    /**
     * Update status komplain (Admin/Seller)
     */
    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        // Pastikan yang bisa mengubah hanya admin atau seller terkait
        if (auth()->id() !== $complaint->seller_id && !auth()->user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki izin.'], 403);
        }

        $complaint->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Status komplain diperbarui!']);
    }
}
