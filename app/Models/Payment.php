<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['order_id', 'gateway', 'method', 'gateway_ref', 'status', 'amount', 'raw_payload', 'paid_at'];
    protected $casts = ['amount' => 'decimal:2', 'raw_payload' => 'array', 'paid_at' => 'datetime'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
