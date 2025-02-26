<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\UserAddress;
use Illuminate\Support\Str;
use Xendit\Invoice\Invoice;
use Illuminate\Http\Request;
use Xendit\Invoice\InvoiceApi;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;
use Xendit\Invoice\CreateInvoiceRequest;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $carts = Cart::with([
            'koi',
            'koi.media' => function ($query) {
                $query->where('media_type', 'photo'); // Hanya ambil media yang berupa foto
            },
            'koi.auction.user',
            'koi.bids' => function ($query) {
                $query->where('is_win', true)->latest();
            }
        ])
            ->where('user_id', $userId)
            ->get();

        // Menambahkan informasi tambahan seperti waktu kemenangan dan kode ikan
        $carts->each(function ($cart) {
            $winnerBid = $cart->koi->bids->firstWhere('is_win', true);
            $cart->koi->win_time = optional($winnerBid)->created_at;
            $cart->koi->auction_code = optional($cart->koi->auction)->auction_code;
        });

        // Grouping berdasarkan toko (farm_name)
        $cartsBySeller = $carts->groupBy(fn($cart) => $cart->koi->auction->user->farm_name ?? 'Tanpa Nama');

        return view('cart.index', compact('cartsBySeller'));
    }


    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'cart_ids' => 'required|json', // Validasi bahwa `cart_ids` harus JSON
        ]);

        $cartIds = json_decode($validated['cart_ids'], true); // Decode JSON menjadi array

        // Fetch cart items berdasarkan ID
        $cartItems = Cart::with([
            'koi',
            'koi.media' => function ($query) {
                $query->where('media_type', 'photo')->limit(1); // Hanya ambil foto pertama
            },
            'koi.auction.user',
        ])->whereIn('id', $cartIds)->get();

        if ($cartItems->isEmpty()) {
            return back()->withErrors('Tidak ada item valid di keranjang.');
        }

        // Kelompokkan item berdasarkan penjual
        $cartsBySeller = $cartItems->groupBy(fn($cart) => $cart->koi->auction->user->farm_name ?? 'Tanpa Nama');

        // Ambil alamat milik user saat ini
        $userAddresses = auth()->user()->addresses()->orderByDesc('is_default')->get();
        $defaultAddress = $userAddresses->first(); // Ambil alamat default pengguna

        // Ambil alamat seller berdasarkan penjual
        $sellerAddresses = $cartItems->map(function ($cart) {
            return [
                'farm_name' => $cart->koi->auction->user->farm_name ?? 'Tidak Diketahui',
                'nama' => $cart->koi->auction->user->name,
                'phone' => $cart->koi->auction->user->phone_number ?? '-',
                'full_address' => $cart->koi->auction->user->city ?? 'Tidak Diketahui',
                'id' => $cart->koi->auction->user->id,
            ];
        })->unique('id'); // Hapus duplikat seller berdasarkan ID

        $paymentGatewayFee = 2500;
        $applicationFee = 1000;

        return view('cart.checkout', [
            'cartsBySeller' => $cartsBySeller, // Kelompokkan berdasarkan penjual
            'userAddresses' => $userAddresses, // Semua alamat milik user
            'defaultAddress' => $defaultAddress, // Default address
            'sellerAddresses' => $sellerAddresses, // Alamat dari seller
            'paymentGatewayFee' => $paymentGatewayFee,
            'applicationFee' => $applicationFee,
        ]);
    }

    public function confirmCheckout(Request $request)
    {
        // Ambil semua input dari request
        $requestData = $request->all();
        $user = Auth::user();

        // Ambil data keranjang dengan relasi yang diperlukan
        $cartItems = Cart::with([
            'koi',
            'koi.auction.user' => function ($query) {
                $query->select('id', 'name', 'phone_number', 'farm_name', 'city'); // Pilih hanya kolom yang diperlukan
            }
        ])->whereIn('id', $request->input('cart_ids'))->get();

        // Validasi jika tidak ada item di keranjang
        if ($cartItems->isEmpty()) {
            return back()->withErrors('Tidak ada item yang valid untuk checkout.');
        }

        try {
            // Hitung biaya
            $baseAmount = $cartItems->sum('price');
            $shippingFees = collect($request->input('shipping_fees'))->sum();
            $rekberFee = $request->input('rekber_fee');
            $paymentGatewayFee = 2500;
            $applicationFee = 1000;
            $totalAmount = $baseAmount + $shippingFees + $rekberFee + $paymentGatewayFee + $applicationFee;

            // Generate deskripsi invoice
            $description = "Pembayaran untuk transaksi batch oleh: " . $user->name;
            $externalId = (string) Str::uuid();

            // Buat invoice di Xendit
            $apiInstance = new InvoiceApi();
            $createInvoiceRequest = new CreateInvoiceRequest([
                'external_id' => $externalId,
                'amount' => $totalAmount,
                'payer_email' => $user->email,
                'description' => $description,
                'invoice_duration' => 2 * 24 * 60 * 60, // Invoice valid for 2 hari
                'currency' => 'IDR',
                'customer' => [
                    'given_name' => $user->name,
                    'email' => $user->email,
                ],
            ]);
            $invoice = $apiInstance->createInvoice($createInvoiceRequest);

            // Simpan transaksi
            $transaction = new Transaction();
            $transaction->user_id = $user->id;
            $transaction->total_amount = $baseAmount;
            $transaction->fee_payment_gateway = $paymentGatewayFee;
            $transaction->fee_application = $applicationFee;
            $transaction->fee_rekber = $rekberFee;
            $transaction->fee_shipping = $shippingFees;
            $transaction->total_with_fees = $totalAmount;
            $transaction->status = 'pending';
            $transaction->external_id = $externalId;
            $transaction->checkout_link = $invoice['invoice_url'];
            $transaction->save();

            // Group carts by seller
            $groupedCarts = $cartItems->groupBy(fn($cart) => $cart->koi->auction->user->farm_name ?? 'Tanpa Nama');

            // Iterate through each seller's group
            foreach ($groupedCarts as $seller => $items) {
                $shippingGroup = Str::uuid();

                foreach ($items as $cart) {
                    $addressData = $request->input("addresses.{$seller}");
                    $address = json_decode($addressData['address_id'] ?? '{}', true); // Decode JSON format untuk buyer/seller

                    // Variabel default
                    $shippingAddress = null;
                    $recipientName = null;
                    $phoneNumber = null;

                    // Tentukan berdasarkan type
                    if (isset($address['type'])) {
                        switch ($address['type']) {
                            case 'buyer':
                            case 'seller':
                                // Gunakan data buyer/seller
                                $shippingAddress = $address['full_address'] ?? 'Alamat tidak tersedia';
                                $recipientName = $address['nama'] ?? 'Nama tidak tersedia';
                                $phoneNumber = $address['phone'] ?? 'No HP tidak tersedia';
                                break;

                            case 'custom':
                                // Gunakan custom address dari input form
                                $shippingAddress = $addressData['custom_address'] ?? 'Alamat tidak tersedia';
                                $recipientName = $addressData['custom_name'] ?? 'Nama tidak tersedia';
                                $phoneNumber = $addressData['custom_phone'] ?? 'No HP tidak tersedia';
                                break;

                            default:
                                // Type tidak dikenal
                                $shippingAddress = 'Alamat tidak diketahui';
                                $recipientName = 'Penerima tidak diketahui';
                                $phoneNumber = 'No HP tidak diketahui';
                                break;
                        }
                    } else {
                        // Jika `type` tidak tersedia dalam address
                        $shippingAddress = 'Alamat tidak diketahui';
                        $recipientName = 'Penerima tidak diketahui';
                        $phoneNumber = 'No HP tidak diketahui';
                    }

                    //Buat instance TransactionItem
                    $transactionItem = [
                        'transaction_id' => $transaction->id,
                        'koi_id' => $cart->koi_id,
                        'price' => $cart->price,
                        'farm' => $cart->koi->auction->user->farm_name,
                        'shipping_fee' => $request->input("shipping_fees.{$seller}") ?? 0,
                        'shipping_address' => $shippingAddress,
                        'farm_owner_name' => $recipientName,
                        'farm_phone_number' => $phoneNumber,
                        'shipping_group' => $shippingGroup,
                    ];
                    $transactionItemsArray[] = $transactionItem;
                    // Simpan TransactionItem
                    $transactionItem = new TransactionItem();
                    $transactionItem->transaction_id = $transaction->id;
                    $transactionItem->koi_id = $cart->koi_id;
                    $transactionItem->price = $cart->price;
                    $transactionItem->farm = $cart->koi->auction->user->farm_name;
                    $transactionItem->shipping_fee = $request->input("shipping_fees.{$seller}") ?? 0;
                    $transactionItem->shipping_address = $shippingAddress;
                    $transactionItem->farm_owner_name = $recipientName;
                    $transactionItem->farm_phone_number = $phoneNumber;
                    $transactionItem->shipping_group = $shippingGroup;
                    // $transactionItem->save();

                    // **Tambahkan Data ke Orders

                    // $ordersArray[] = [
                    //     'buyer_id' => $user->id,
                    //     'seller_id' => $cart->koi->auction->user->id,
                    //     'koi_id' => $cart->koi->id,
                    //     'transaction_id' => $transaction->id,
                    //     'total_price' => $cart->price,
                    //     'status' => 'pending', // Status awal pesanan
                    //     'shipping_address' => $shippingAddress,
                    //     'recipient_name' => $recipientName,
                    //     'recipient_phone' => $phoneNumber,
                    //     'shipping_group' => $shippingGroup,
                    //     'created_at' => now(),
                    //     'updated_at' => now(),
                    // ];

                    // $order = new Order();
                    // $order->buyer_id = $user->id;
                    // $order->seller_id = $cart->koi->auction->user->id;
                    // $order->koi_id = $cart->koi->id;
                    // $order->transaction_id = $transaction->id;
                    // $order->total_price = $cart->price;
                    // $order->status = 'pending'; // Status awal pesanan
                    // $order->shipping_address = $shippingAddress;
                    // $order->recipient_name = $recipientName;
                    // $order->recipient_phone = $phoneNumber;
                    // $order->shipping_group = $shippingGroup;
                    // $order->save();

                }
            }

            // Hapus item dari cart
            // $cartItems->each->delete();

            // Redirect ke Xendit payment link
            // return redirect()->away($invoice['invoice_url']);

            return view('cart.testCheckout', [
                'requestData' => $requestData,      // Semua data request
                'cartItems' => $cartItems,          // Item di keranjang
                'totalAmount' => $totalAmount,      // Total biaya
                'groupedCarts' => $groupedCarts,    // Grup item per penjual
                'transaction' => $transaction,      // Simulasi data transaksi
                'transactionItems' => $transactionItemsArray,      // Simulasi data transaksi
                // 'orders' => $ordersArray,           // Simulasi data pesanan
                'invoice' => $invoice,              // Simulasi invoice Xendit
            ]);
        } catch (\Exception $e) {
            return redirect()->route('cart.failed')->with('errorMessage', $e->getMessage());
        }
    }
    public function checkoutFailed(Request $request)
    {
        return view('cart.failed', ['errorMessage' => session('errorMessage')]);
    }
}
