<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\TransactionItem;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updating(Order $order)
    {
        // Jika status order berubah, update status transaction_items
        if ($order->isDirty('status')) {
            TransactionItem::where('transaction_id', $order->transaction_id)
                ->where('koi_id', $order->koi_id)
                ->update(['status' => $order->status]);
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
