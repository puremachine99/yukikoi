<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = [
        'transaction_id',
        'koi_id',
        'farm',
        'price',
        'shipping_fee',
        'shipping_group',
        'farm',
        'farm_owner_name',
        'farm_phone_number',
        'shipping_address',
        'status',
    ];
    public function getStatusAttribute()
    {
        if ($this->orders->every(fn($o) => $o->status === 'selesai')) {
            return 'selesai';
        } elseif ($this->orders->contains('status', 'dikirim')) {
            return 'dikirim';
        } elseif ($this->orders->contains('status', 'sedang dikemas')) {
            return 'sedang dikemas';
        } elseif ($this->orders->contains('status', 'menunggu konfirmasi')) {
            return 'menunggu konfirmasi';
        } else {
            return 'tidak diketahui';
        }
    }


    public function koi()
    {
        return $this->belongsTo(Koi::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'transaction_id');
    }
}
