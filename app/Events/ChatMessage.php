<?php
namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ChatMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chat;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    public function broadcastOn()
    {
        return new Channel('koi.' . $this->chat->koi_id); // Broadcast ke channel yang sesuai dengan Koi ID
    }

    public function broadcastWith()
    {
        // Data yang akan dikirim ke client-side
        return [
            'chat' => [
                'id' => $this->chat->id,
                'message' => $this->chat->message,
                'user' => [
                    'id' => $this->chat->user->id,
                    'name' => $this->chat->user->name,
                    'pp' => $this->chat->user->profile_photo,
                    'phone_number' => substr($this->chat->user->phone_number, 0, 4) . 'XX' . substr($this->chat->user->phone_number, -2),
                ],
                'created_at' => $this->chat->created_at->toDateTimeString(),
            ],
        ];
    }
}
