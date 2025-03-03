<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Rating;
use App\Models\Transaction;

use Illuminate\Support\Str;
use Xendit\Invoice\Invoice;
use Illuminate\Http\Request;
use App\Models\StatusHistory;
use Xendit\Invoice\InvoiceApi;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\Invoice as XenditInvoice;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        $status = $request->query('status', 'semua');

        // Daftar tab status
        $tabs = [
            'semua' => 'Semua',
            'menunggu konfirmasi' => 'Menunggu Konfirmasi',
            'sedang dikemas' => 'Sedang Dikemas',
            'dikirim' => 'Dikirim',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
        ];

        // Query transaksi dengan eager loading untuk hindari N+1 !! teruwet
        $transactionsQuery = Transaction::with([
            'transactionItems' => function ($query) {
                $query->with([
                    'koi' => function ($koiQuery) {
                        $koiQuery->with([
                            'media' => function ($mediaQuery) {
                                $mediaQuery->where('media_type', 'photo')->select('id', 'koi_id', 'url_media');
                            },
                            'auction.user' => function ($userQuery) {
                                $userQuery->select('id', 'name', 'phone_number');
                            }
                        ])->select('id', 'judul', 'jenis_koi', 'ukuran', 'auction_code');
                    }
                ])->select('id', 'transaction_id', 'koi_id', 'price', 'farm', 'status'); // Optimasi select
            }
        ])->where('user_id', $userId);

        // Filter berdasarkan status
        if ($status !== 'semua') {
            $transactionsQuery->whereHas('transactionItems', function ($query) use ($status) {
                $query->where('status', $status);
            });
        }

        // Ambil transaksi & kelompokkan berdasarkan farm
        $transactions = $transactionsQuery->get();
        $groupedTransactions = $transactions->groupBy(fn($transaction) => $transaction->transactionItems->first()->farm ?? 'Unknown');

        return view('transactions.index', compact('tabs', 'status', 'groupedTransactions'));
    }

    public function show($id)
    {
        // Ambil transaksi dengan relasi koi, media, user (buyer), dan user penjual melalui auction
        $transaction = Transaction::with([
            'koi.media' => function ($query) {
                $query->where('media_type', 'photo'); // Hanya ambil media yang berupa foto
            },
            'user', // Relasi pembeli langsung dari transaksi
            'koi.auction.user', // Relasi penjual melalui auction pada koi
            'koi.bids' // Menambahkan relasi bids untuk cek cara menang
        ])->findOrFail($id);

        // Ambil pembeli dari user relasi transaksi
        $buyer = $transaction->user;

        // Ambil penjual dengan relasi melalui auction pada koi
        $seller = optional($transaction->koi->auction)->user;

        // Cek cara kemenangan (Buy It Now atau Natural)
        $winningMethod = 'Natural'; // Default ke Natural
        $lastBid = $transaction->koi->bids->last(); // Ambil bid terakhir

        if ($lastBid && $lastBid->is_bin) {
            $winningMethod = 'By Buy It Now';
        }

        return view('transactions.show', compact('transaction', 'buyer', 'seller', 'winningMethod'));
    }

    // app/Http/Controllers/TransactionController.php

    public function pay(Request $request, Transaction $transaction)
    {
        $request->validate([
            'rekber_fee' => 'required|numeric|min:0'
        ]);
        // Ambil data dari input
        $rekberFee = $request->input('rekber_fee', 0);

        // Hitung biaya tambahan
        $totalAmount = $transaction->total_amount;
        $paymentGatewayFee = $transaction->payment_gateway_fee;
        $handlingFee = $transaction->handling_fee;

        $totalWithFees = $totalAmount + $paymentGatewayFee + $handlingFee + $rekberFee;

        // Update biaya-biaya di table transaction
        $transaction->update([
            'rekber_fee' => $rekberFee,
            'total_with_fees' => $totalWithFees,
        ]);

        // Buat Invoice di Xendit
        $externalId = (string) Str::uuid();
        $description = "Pembayaran Lelang {$transaction->koi->judul} ({$transaction->koi->ukuran}cm - {$transaction->koi->gender})";
        $description .= "\nHarga Dasar: Rp " . number_format($transaction->total_amount, 0, ',', '.');
        $description .= "\nBiaya Payment Gateway: Rp " . number_format($transaction->payment_gateway_fee, 0, ',', '.');
        $description .= "\nBiaya Penanganan: Rp " . number_format($transaction->handling_fee, 0, ',', '.');
        $description .= "\nBiaya Rekber: Rp " . number_format($rekberFee, 0, ',', '.');

        $apiInstance = new \Xendit\Invoice\InvoiceApi();
        $createInvoiceRequest = new \Xendit\Invoice\CreateInvoiceRequest([
            'external_id' => $externalId,
            'description' => $description,
            'amount' => $totalWithFees,
            'invoice_duration' => 2 * 24 * 60 * 60,
            'currency' => 'IDR',
            'customer' => [
                'given_name' => $transaction->user->name,
                'email' => $transaction->user->email,
            ],
        ]);

        try {
            // Buat invoice di Xendit
            $result = $apiInstance->createInvoice($createInvoiceRequest);

            // Update data transaksi
            $transaction->update([
                'external_id' => $externalId,
                'checkout_link' => $result['invoice_url'],
                'status' => 'pending',
                'payment_deadline' => now()->addDays(2),
            ]);

            // Redirect langsung ke link checkout
            return redirect()->away($result['invoice_url']);
        } catch (\Exception $e) {

            return back()->with('error', 'Gagal membuat invoice. Silakan coba lagi.');
        }
    }
    public function payBatch(Request $request)
    {
        $transactionIds = $request->input('transaction_ids', []);
        $user = Auth::user();

        // Validasi transaksi
        $transactions = Transaction::whereIn('id', $transactionIds)
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->get();

        if ($transactions->count() !== count($transactionIds)) {
            return response()->json(['error' => 'Invalid transactions selected.'], 400);
        }

        // Hitung total biaya
        $totalAmount = $transactions->sum('total_with_fees');

        // Buat invoice baru
        $invoice = Invoice::create([
            'user_id' => $user->id,
            'invoice_code' => 'INV-' . strtoupper(Str::random(10)),
            'total_amount' => $totalAmount,
        ]);

        // Hubungkan transaksi ke invoice
        foreach ($transactions as $transaction) {
            $transaction->update(['invoice_id' => $invoice->id]);
        }

        // Buat invoice di Xendit
        $apiInstance = new \Xendit\Invoice\InvoiceApi();
        $createInvoiceRequest = new \Xendit\Invoice\CreateInvoiceRequest([
            'external_id' => $invoice->invoice_code,
            'description' => "Pembayaran Lelang",
            'amount' => $totalAmount,
            'invoice_duration' => 2 * 24 * 60 * 60,
            'currency' => 'IDR',
            'customer' => [
                'given_name' => $user->name,
                'email' => $user->email,
            ],
        ]);

        try {
            $result = $apiInstance->createInvoice($createInvoiceRequest);

            // Update invoice dengan link Xendit
            $invoice->update([
                'checkout_link' => $result['invoice_url'],
                'payment_deadline' => now()->addDays(2),
            ]);

            return redirect()->away($result['invoice_url']);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat invoice batch: ' . $e->getMessage());
        }
    }
    // app/Http/Controllers/TransactionController.php
    public function updateStatus(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:transaction_items,id',
            'status' => 'required|in:selesai'
        ]);

        // Ambil TransactionItem berdasarkan ID
        $item = TransactionItem::findOrFail($request->item_id);

        // Pastikan hanya Buyer yang bisa menyelesaikan transaksi
        if (auth()->id() !== $item->transaction->user_id) {
            return response()->json(['success' => false, 'message' => 'Anda tidak berhak mengubah status ini.'], 403);
        }

        // Update status transaction_item ke 'selesai'
        $item->update(['status' => $request->status]);

        // Simpan log perubahan status di StatusHistory
        StatusHistory::create([
            'transaction_item_id' => $item->id,
            'order_id' => null, // Order akan ditentukan nanti
            'status' => $request->status,
            'changed_by' => auth()->id(),
            'changed_at' => now(),
        ]);

        // Cek apakah semua items dalam transaksi ini sudah selesai
        $transactionId = $item->transaction_id;
        $koiId = $item->koi_id;

        $allItemsDone = TransactionItem::where('transaction_id', $transactionId)
            ->where('koi_id', $koiId)
            ->where('status', '!=', 'selesai')
            ->doesntExist();

        if ($allItemsDone) {
            // Update status di tabel orders juga
            $order = Order::where('transaction_id', $transactionId)
                ->where('koi_id', $koiId)
                ->first();

            if ($order) {
                $order->update(['status' => 'selesai']);

                // Simpan log perubahan status di StatusHistory untuk Order
                StatusHistory::create([
                    'order_id' => $order->id,
                    'transaction_item_id' => $item->id, // Tautkan dengan transaction_item yang selesai
                    'status' => 'selesai',
                    'changed_by' => auth()->id(),
                    'changed_at' => now(),
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Status transaksi berhasil diperbarui!']);
    }




    public function retur(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:transaction_items,id',
            'reason' => 'required|string',
            'proof' => 'required|file|mimes:mp4,mov,avi|max:51200'
        ]);

        $proofPath = $request->file('proof')->store('retur_proofs', 'public');

        $item = TransactionItem::findOrFail($request->item_id);
        $item->update([
            'status' => 'retur',
            'retur_reason' => $request->reason,
            'retur_proof' => $proofPath
        ]);

        // Cek jika semua item dalam order diretur, update order menjadi retur
        $order = Order::where('id', $item->order_id)->first();
        if ($order && $order->transactionItems()->where('status', '!=', 'retur')->count() == 0) {
            $order->update(['status' => 'retur']);
        }

        return response()->json(['success' => true, 'message' => 'Retur berhasil diajukan!']);
    }


    public function storeRating(Request $request)
    {
        $request->validate([
            'transaction_item_id' => 'required|exists:transaction_items,id',
            'rating_quality' => 'required|numeric|min:1|max:5',
            'rating_shipping' => 'required|numeric|min:1|max:5',
            'rating_service' => 'required|numeric|min:1|max:5',
            'review' => 'nullable|string',
        ]);

        $transactionItem = TransactionItem::findOrFail($request->transaction_item_id);

        if ($transactionItem->transaction->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Anda tidak berhak memberi rating.'], 403);
        }

        Rating::updateOrCreate(
            ['transaction_item_id' => $transactionItem->id],
            [
                'buyer_id' => auth()->id(),
                'seller_id' => $transactionItem->koi->auction->user_id,
                'rating_quality' => $request->rating_quality,
                'rating_shipping' => $request->rating_shipping,
                'rating_service' => $request->rating_service,
                'review' => $request->review,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Rating berhasil dikirim.']);
    }


}
