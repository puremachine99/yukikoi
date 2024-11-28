<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Str;
use Xendit\Invoice\Invoice as XenditInvoice;

use Illuminate\Http\Request;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Support\Facades\Auth;
use Xendit\Invoice\CreateInvoiceRequest;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // Ambil status dari query string (default: "all")
        $status = $request->query('status', 'all');

        // Ambil user yang sedang login
        $user = auth()->user();

        // Query transaksi berdasarkan status
        $transactions = Transaction::with([
            'transactionItems.koi.media' => function ($query) {
                $query->where('media_type', 'photo'); // Hanya ambil media foto
            },
            'transactionItems.koi.auction.user' // Load farm name via auction's user
        ])
            ->where('user_id', $user->id)
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->get();


        // Group by farm name
        $groupedTransactions = $transactions->groupBy(
            fn($transaction) =>
            $transaction->transactionItems->first()->koi->auction->user->farm_name ?? 'Tidak Diketahui'
        );

        // Mapping kategori tab
        $tabs = [
            'all' => 'Semua',
            'on_process' => 'Sedang Dikemas',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'canceled' => 'Dibatalkan',
        ];

        // Return ke view
        return view('transactions.index', compact('groupedTransactions', 'tabs', 'status'));
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
        $user = auth()->user();

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
}
