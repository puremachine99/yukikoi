<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Bid;

class PlaceBid implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bid;
    public $isSniping;

    /**
     * Create a new event instance.
     */
    public function __construct(Bid $bid, $isSniping)
    {
        $this->bid = $bid; // bid nyar
        $this->isSniping = $isSniping;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        // Kirim event ini di channel 'koi.{koiId}'
        return new Channel('koi.' . $this->bid->koi_id);
    }

    /**
     * Data yang dikirim ke client-side saat event disiarkan
     */
    public function broadcastWith()
    {
        // Data yang akan dikirim ke client-side
        return [
            'bid' => [
                'id' => $this->bid->id,
                'koi_id' => $this->bid->koi_id,
                'amount' => $this->bid->amount,
                'user' => [
                    'id' => $this->bid->user->id,
                    'name' => $this->bid->user->name,
                    'pp' => $this->bid->user->profile_photo,
                    'phone_number' => substr($this->bid->user->phone_number, 0, 4) . 'XX' . substr($this->bid->user->phone_number, -2),
                ],
                'created_at' => $this->bid->created_at->toDateTimeString(),
            ],
            'isSniping' => $this->isSniping,
        ];
    }
}
