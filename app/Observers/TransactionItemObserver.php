<?php

namespace App\Observers;

use App\Models\TransactionItem;

class TransactionItemObserver
{
    /**
     * Handle the TransactionItem "updating" event.
     */
    public function updating(TransactionItem $transactionItem)
    {
        // Cek apakah status berubah
        if ($transactionItem->isDirty('status')) {
            \Log::info("Status TransactionItem berubah: {$transactionItem->status}");

            // Simpan riwayat perubahan status (Jika ada StatusHistory Model)
            if (class_exists('\App\Models\StatusHistory')) {
                \App\Models\StatusHistory::create([
                    'transaction_item_id' => $transactionItem->id,
                    'status' => $transactionItem->status,
                    'changed_by' => auth()->id(),
                    'changed_at' => now(),
                ]);
            }
        }
    }
}
