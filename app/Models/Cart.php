<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke tabel Koi
    public function koi()
    {
        return $this->belongsTo(Koi::class);
    }

    // Relasi ke Auction melalui Koi
    public function auction()
    {
        return $this->koi->auction();
    }

    // Relasi ke User sebagai Buyer
    public function buyer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke User sebagai Seller melalui Koi dan Auction
    public function seller()
    {
        return $this->koi->auction->user();
    }
}

