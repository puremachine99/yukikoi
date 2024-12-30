<?php

/**
namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Auction;
use Xendit\Configuration;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Events\AuctionEnded;
use Illuminate\Bus\Queueable;
use App\Events\AuctionStarted;
use App\Events\ExtraTimeAdded;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Xendit\Invoice\CreateInvoiceRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateAuctionStatus
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $auctionCode;


    public function __construct($auctionCode)
    {
        $this->auctionCode = $auctionCode;
    }




    public function handle()
    {
        // Cari auction berdasarkan kode lelang
        $auction = Auction::where('auction_code', $this->auctionCode)->firstOrFail();
        $now = Carbon::now();

        // Abaikan status 'draft' dan 'completed'
        if (in_array($auction->status, ['draft', 'completed'])) {
            return;
        }

        // Jika status lelang 'ready' dan sudah mencapai waktu mulai
        if ($auction->status === 'ready' && $now >= $auction->start_time) {
            $auction->status = 'on going';
            $auction->save();
            event(new AuctionStarted($auction)); // Broadcast event Mulai Lelang
        }
        // Jika lelang sedang berjalan dan sudah mencapai waktu akhir
        elseif ($auction->status === 'on going') {
            $adjustedEndTime = Carbon::parse($auction->end_time)->addMinutes($auction->extra_time);

            if ($now >= $adjustedEndTime) {
                $auction->status = 'completed';
                $auction->save();
                event(new AuctionEnded($auction)); // Broadcast event Lelang Selesai
                $this->determineWinner($auction); // Tentukan pemenang dan buat invoice
            }
        }
    }


    protected function determineWinner(Auction $auction)
    {
        foreach ($auction->koi as $koi) {
            $latestBid = $koi->bids->last();

            if ($latestBid && $latestBid->is_bin) {
                continue;
            }

            if ($latestBid) {
                $latestBid->is_win = true;
                $latestBid->save();

                $user = $latestBid->user;
                $feePercentage = $auction->jenis === 'reguler' ? 5 : 7.5;
                $feeAmount = ($latestBid->amount * ($feePercentage / 100)) * 1000;
                $handlingFee = 1000;
                $paymentGatewayFee = 2500;
                $rekberFee = $auction->jenis === 'reguler' && count($auction->koi) > 1 ? 15000 : 10000;

                // Total keseluruhan
                $totalWithFees = ($latestBid->amount * 1000)  + $handlingFee + $paymentGatewayFee + $rekberFee;



                $externalId = (string) Str::uuid();

                $apiInstance = new InvoiceApi();
                $createInvoiceRequest = new CreateInvoiceRequest([
                    'external_id' => $externalId,
                    'description' => "Pembayaran Lelang {$koi->id} - {$koi->judul} {$koi->ukuran}cm ({$koi->gender})",
                    'amount' => $totalWithFees,
                    'invoice_duration' => 2 * 24 * 60 * 60,
                    'currency' => 'IDR',
                    'customer' => [
                        'given_name' => $user->name,
                        'email' => $user->email,
                    ],
                ]);

                try {
                    $result = $apiInstance->createInvoice($createInvoiceRequest);

                    // Simpan transaksi di database
                    Transaction::create([
                        'auction_code' => $auction->auction_code,
                        'koi_id' => $koi->id,
                        'user_id' => $user->id,
                        'external_id' => $externalId,
                        'checkout_link' => $result['invoice_url'],
                        'total_amount' => $latestBid->amount * 1000, // Pastikan ini sesuai dengan biaya yang ingin kamu simpan
                        'fee_amount' => $feeAmount,
                        'fee_percentage' => $feePercentage,
                        'payment_gateway_fee' => $paymentGatewayFee,
                        'handling_fee' => $handlingFee,
                        'rekber_fee' => $rekberFee,
                        'total_with_fees' => $totalWithFees,
                        'status' => 'pending',
                        'payment_deadline' => now()->addDays(2),
                    ]);
                } catch (\Exception $e) {
                }
            }
        }
    }
} */

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Auction;
use App\Models\Event;
use Xendit\Configuration;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Events\AuctionEnded;
use Illuminate\Bus\Queueable;
use App\Events\AuctionStarted;
use App\Events\ExtraTimeAdded;
use Xendit\Invoice\InvoiceApi;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Xendit\Invoice\CreateInvoiceRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateAuctionStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $auctionCode;

    public function __construct($auctionCode)
    {
        $this->auctionCode = $auctionCode;
    }

    public function handle()
    {
        $auction = Auction::with('event')->where('auction_code', $this->auctionCode)->firstOrFail();
        $now = Carbon::now();

        if (in_array($auction->status, ['draft', 'completed'])) {
            return;
        }

        if ($auction->status === 'ready' && $now >= $auction->start_time) {
            $auction->status = 'on going';
            $auction->save();
            event(new AuctionStarted($auction));
        } elseif ($auction->status === 'on going') {
            $adjustedEndTime = Carbon::parse($auction->end_time)->addMinutes($auction->extra_time);

            if ($now >= $adjustedEndTime) {
                $auction->status = 'completed';
                $auction->save();
                event(new AuctionEnded($auction));
                $this->determineWinner($auction);

                // Update event status if related
                if ($auction->event) {
                    $this->updateEventStatus($auction->event);
                }
            }
        }
    }

    protected function determineWinner(Auction $auction)
    {
        foreach ($auction->koi as $koi) {
            $latestBid = $koi->bids->last();

            if ($latestBid && $latestBid->is_bin) {
                continue;
            }

            if ($latestBid) {
                $latestBid->is_win = true;
                $latestBid->save();

                $user = $latestBid->user;
                $feePercentage = $auction->jenis === 'reguler' ? 5 : 7.5;
                $feeAmount = ($latestBid->amount * ($feePercentage / 100)) * 1000;
                $handlingFee = 1000;
                $paymentGatewayFee = 2500;
                $rekberFee = $auction->jenis === 'reguler' && count($auction->koi) > 1 ? 15000 : 10000;

                $totalWithFees = ($latestBid->amount * 1000) + $handlingFee + $paymentGatewayFee + $rekberFee;

                $externalId = (string) Str::uuid();

                $apiInstance = new InvoiceApi();
                $createInvoiceRequest = new CreateInvoiceRequest([
                    'external_id' => $externalId,
                    'description' => "Pembayaran Lelang {$koi->id} - {$koi->judul} {$koi->ukuran}cm ({$koi->gender})",
                    'amount' => $totalWithFees,
                    'invoice_duration' => 2 * 24 * 60 * 60,
                    'currency' => 'IDR',
                    'customer' => [
                        'given_name' => $user->name,
                        'email' => $user->email,
                    ],
                ]);

                try {
                    $result = $apiInstance->createInvoice($createInvoiceRequest);

                    Transaction::create([
                        'auction_code' => $auction->auction_code,
                        'koi_id' => $koi->id,
                        'user_id' => $user->id,
                        'external_id' => $externalId,
                        'checkout_link' => $result['invoice_url'],
                        'total_amount' => $latestBid->amount * 1000,
                        'fee_amount' => $feeAmount,
                        'fee_percentage' => $feePercentage,
                        'payment_gateway_fee' => $paymentGatewayFee,
                        'handling_fee' => $handlingFee,
                        'rekber_fee' => $rekberFee,
                        'total_with_fees' => $totalWithFees,
                        'status' => 'pending',
                        'payment_deadline' => now()->addDays(2),
                    ]);
                } catch (\Exception $e) {
                    // Log error
                }
            }
        }
    }

    protected function updateEventStatus(Event $event)
    {
        $ongoingAuctions = $event->auctions()->where('status', 'on going')->exists();
        if (!$ongoingAuctions) {
            $event->update(['status' => 'completed']);
        }
    }
}
