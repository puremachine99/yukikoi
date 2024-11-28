<?php

namespace App\Events;

use App\Models\Bid;
use App\Models\Auction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;


class AuctionWon implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $bid;

    public function __construct($bid)
    {
        $this->bid = $bid;
    }

    public function broadcastOn()
    {
        return new Channel('koi.' . $this->bid->koi_id);
    }

    public function broadcastWith()
    {
        return [
            'winner' => [
                'koi_id' => $this->bid->koi_id,
                'id' => $this->bid->user->id,
                'name' => $this->bid->user->name,
                'amount' => $this->bid->amount,
                'pp' => $this->bid->user->profile_photo,
            ],
        ];
    }
}
