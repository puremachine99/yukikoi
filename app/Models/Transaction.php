<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'fee_payment_gateway',
        'fee_application',
        'fee_rekber',
        'fee_shipping',
        'total_with_fees',
        'status',
        'external_id',
        'checkout_link',
    ];

    public function koi()
    {
        return $this->belongsTo(Koi::class, 'koi_id', 'id');
    }
    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id');
    }
}
