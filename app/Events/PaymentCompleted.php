<?php

namespace App\Events;

use App\Models\Transaction;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class PaymentCompleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function broadcastOn()
    {
        // Hanya user terkait yang menerima notifikasi di PrivateChannel
        return new PrivateChannel('user.' . $this->transaction->user_id);
    }

    public function broadcastWith()
    {
        return [
            'message' => 'Pembayaran berhasil!',
            'transaction_id' => $this->transaction->id,
            'amount' => $this->transaction->total_amount,
        ];
    }
}
