<?php

namespace App\Notifications;

use App\Models\Bid;
use Illuminate\Bus\Queueable;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewBidNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Bid $bid)
    {
        $this->bid->loadMissing('koi', 'user');
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Bid baru pada ' . ($this->bid->koi->judul ?? 'koi'),
            'message' => $this->bid->user->name . ' menawar Rp ' . number_format($this->bid->amount, 0, ',', '.'),
            'icon' => 'fa-gavel',
            'severity' => 'info',
            'action_url' => route('koi.show', $this->bid->koi_id),
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
        return 'new-bid';
    }
}
