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
        return [
            'chat' => [
                'id' => $this->chat->id,
                'message' => $this->chat->message,
                'user' => [
                    'id' => $this->chat->user->id,
                    'name' => $this->chat->user->name,
                    'pp' => $this->chat->user->profile_photo ?: 'https://via.placeholder.com/40',
                    'phone_number' => $this->maskPhoneNumber($this->chat->user->phone_number),
                ],
                'created_at' => $this->chat->created_at->toDateTimeString(),
            ],
        ];
    }

    private function maskPhoneNumber(?string $phoneNumber): ?string
    {
        if (!$phoneNumber) {
            return null;
        }

        $digitsOnly = preg_replace('/\D+/', '', $phoneNumber);
        $length = strlen($digitsOnly);

        if ($length <= 4) {
            return $digitsOnly;
        }

        $prefix = substr($digitsOnly, 0, min(4, $length));
        $suffix = $length > 2 ? substr($digitsOnly, -2) : '';

        return $suffix ? "{$prefix}XX{$suffix}" : $prefix;
    }
}
