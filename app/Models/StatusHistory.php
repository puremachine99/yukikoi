<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusHistory extends Model
{
    protected $fillable = [
        'transaction_item_id',
        'status',
        'changed_at',
        'changed_by'
    ];

    public function transactionItem()
    {
        return $this->belongsTo(TransactionItem::class, 'transaction_item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
