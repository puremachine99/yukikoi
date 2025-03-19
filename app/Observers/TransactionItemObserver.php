<?php
namespace App\Observers;

use App\Models\TransactionItem;

class TransactionItemObserver
{
    public function updating(TransactionItem $transactionItem)
    {
        if ($transactionItem->isDirty('status')) {
            \Log::info("Status TransactionItem berubah: {$transactionItem->status}");

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
