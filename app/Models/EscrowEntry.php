<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscrowEntry extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['order_id', 'type', 'amount', 'note'];
    protected $casts = ['amount' => 'decimal:2'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
