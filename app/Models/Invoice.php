<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['payer_id', 'purpose', 'currency', 'amount', 'status', 'gateway', 'external_ref', 'metadata', 'expires_at', 'paid_at'];
    protected $casts = ['amount' => 'decimal:2', 'metadata' => 'array', 'expires_at' => 'datetime', 'paid_at' => 'datetime'];

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }
}
