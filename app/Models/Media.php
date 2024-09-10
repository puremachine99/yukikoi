<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'koi_id',
        'url_media',
        'media_type',
    ];

    // Relasi ke model Koi
    public function koi()
    {
        return $this->belongsTo(Koi::class);
    }
}
