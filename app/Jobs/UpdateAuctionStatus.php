<?php

namespace App\Jobs;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class UpdateAuctionStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $auctionId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($auctionId)
    {
        $this->auctionId = $auctionId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $now = Carbon::now();

        // Cari auction berdasarkan ID
        $auction = Auction::findOrFail($this->auctionId);

        // Mengubah status menjadi 'ready' jika sekarang kurang dari start_time
        if ($now < $auction->start_time && $auction->status === 'draft') {
            $auction->status = 'ready';
        }
        // Mengubah status menjadi 'on going' jika sekarang antara start_time dan end_time
        elseif ($now >= $auction->start_time && $now <= $auction->end_time && $auction->status !== 'completed') {
            $auction->status = 'on going';
        }
        // Mengubah status menjadi 'completed' jika sekarang lebih dari end_time
        elseif ($now > $auction->end_time && $auction->status !== 'completed') {
            $auction->status = 'completed';
        }

        // Simpan perubahan status
        $auction->save();
    }
}
