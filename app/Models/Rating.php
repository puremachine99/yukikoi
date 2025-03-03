<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_item_id',
        'buyer_id',
        'seller_id',
        'rating_quality',
        'rating_shipping',
        'rating_service',
        'review',
    ];

    public function transactionItem()
    {
        return $this->belongsTo(TransactionItem::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
