<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ExtraTimeAdded implements ShouldBroadcastNow
{
    use InteractsWithSockets;

    public function __construct(
        public readonly string $auctionCode,
        public readonly int $extraTime,
        public readonly string $newEndTime,
        public readonly int $addedMinutes = 0,
    ) {
    }

    public function broadcastOn(): Channel
    {
        return new Channel('auction.' . $this->auctionCode);
    }

    public function broadcastWith(): array
    {
        return [
            'auction_code' => $this->auctionCode,
            'extra_time' => $this->extraTime,
            'new_end_time' => $this->newEndTime,
            'added_minutes' => $this->addedMinutes,
        ];
    }
}
