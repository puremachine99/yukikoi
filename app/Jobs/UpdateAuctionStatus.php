<?php

namespace App\Jobs;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class UpdateAuctionStatus
{
    use Dispatchable, SerializesModels;

    protected $auctionCode;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($auctionCode)
    {
        $this->auctionCode = $auctionCode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Cari auction berdasarkan kode lelang
        $auction = Auction::where('auction_code', $this->auctionCode)->firstOrFail();
        $now = Carbon::now();

        // Abaikan status 'draft' dan 'completed'
        if (in_array($auction->status, ['draft', 'completed'])) {
            return;
        }

        // Jika status 'ready'
        if ($auction->status === 'ready') {
            if ($now >= $auction->start_time) {
                $auction->status = 'on going';
                $auction->save();
            }
        } elseif ($auction->status === 'on going') {
            if ($now >= $auction->end_time) {
                $auction->status = 'completed';
                $auction->save();
            }
        }
    }
}
