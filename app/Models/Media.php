<?php

namespace App\Models;

use App\Support\Media as MediaSupport;
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
    protected $appends = ['proxy_url'];

    // Relasi ke model Koi
    public function koi()
    {
        return $this->belongsTo(Koi::class);
    }

    public function getProxyUrlAttribute(): string
    {
        return MediaSupport::url($this->url_media, [
            'resize' => ['fill', 1024, 768, 1],
        ]);
    }
}
