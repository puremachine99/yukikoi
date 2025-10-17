<?php

namespace App\Notifications;

use App\Models\Bid;
use Illuminate\Bus\Queueable;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class OutbidNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Bid $previousBid, private Bid $newBid)
    {
        $this->previousBid->loadMissing('koi');
        $this->newBid->loadMissing('user', 'koi');
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Kamu dikalahkan',
            'message' => ($this->newBid->user->name ?? 'Peserta lain') . ' menawar Rp ' . number_format($this->newBid->amount, 0, ',', '.') . ' pada ' . ($this->previousBid->koi->judul ?? 'koi'),
            'icon' => 'fa-triangle-exclamation',
            'severity' => 'warning',
            'action_url' => route('koi.show', $this->previousBid->koi_id),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function broadcastOn($notifiable): PrivateChannel
    {
        return new PrivateChannel('user.' . $notifiable->getKey());
    }

    public function broadcastType(): string
    {
        return 'bid-outbid';
    }
}
