<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'koi_id',
        'url_gambar'
    ];

    // Relasi ke Koi
    public function koi()
    {
        return $this->belongsTo(Koi::class);
    }
}
