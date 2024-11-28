<?php
// app/Events/ExtraTimeAdded.php
namespace App\Events;

use App\Models\Auction;  // Tambahkan import untuk model Auction
use Carbon\Carbon;       // Tambahkan import untuk Carbon
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ExtraTimeAdded implements ShouldBroadcastNow
{
    public $auctionCode;
    public $extraTime;

    public function __construct($auctionCode, $extraTime)
    {
        $this->auctionCode = $auctionCode;
        $this->extraTime = $extraTime;
    }

    public function broadcastOn()
    {
        return new Channel('koi.' . $this->auctionCode);
    }

    public function broadcastWith()
    {
        // Ambil auction dari database berdasarkan auction_code
        $auction = Auction::where('auction_code', $this->auctionCode)->firstOrFail();

        return [
            'auction_code' => $this->auctionCode,
            'extra_time' => $this->extraTime,
            'new_end_time' => Carbon::parse($auction->end_time)
                ->addMinutes($auction->extra_time) // Hitung waktu baru berdasarkan extra_time
                ->toDateTimeString(), // Format waktu sebagai string
        ];
    }
}
