<?php

namespace App\Notifications;

use App\Models\Bid;
use Illuminate\Bus\Queueable;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class AuctionWonNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Bid $winningBid, private bool $forSeller = false)
    {
        $this->winningBid->loadMissing('koi', 'user', 'koi.auction');
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        $koi = $this->winningBid->koi;
        $buyer = $this->winningBid->user;

        return [
            'title' => $this->forSeller ? 'Koi kamu terjual' : 'Selamat! Kamu menang',
            'message' => $this->forSeller
                ? ($buyer->name ?? 'Pembeli') . ' memenangkan ' . ($koi->judul ?? 'koi') . ' seharga Rp ' . number_format($this->winningBid->amount, 0, ',', '.')
                : 'Kamu memenangkan ' . ($koi->judul ?? 'koi') . ' seharga Rp ' . number_format($this->winningBid->amount, 0, ',', '.'),
            'icon' => $this->forSeller ? 'fa-sack-dollar' : 'fa-trophy',
            'severity' => $this->forSeller ? 'success' : 'primary',
            'action_url' => route('transactions.index'),
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
        return 'auction-won';
    }
}
