<?php

namespace App\Events;

use App\Models\Bid;
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

    public function __construct(Bid $bid)
    {
        $this->bid = $bid->loadMissing('user');
    }

    public function broadcastOn()
    {
        return new Channel('koi.' . $this->bid->koi_id);
    }

    public function broadcastWith()
    {
        return [
            'winner' => [
                'bid_id' => $this->bid->id,
                'koi_id' => $this->bid->koi_id,
                'user_id' => $this->bid->user->id,
                'name' => $this->bid->user->name,
                'amount' => $this->bid->amount,
                'pp' => $this->bid->user->profile_photo,
            ],
        ];
    }
}
