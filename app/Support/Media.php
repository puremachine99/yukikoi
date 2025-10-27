<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class Media
{
    public static function url(?string $path, array $options = [], ?string $fallback = null): string
    {
        if (blank($path)) {
            return $fallback ?? asset('images/logo.png');
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            $source = $path;
        } else {
            $disk = Storage::disk(config('filesystems.default', 's3'));
            $source = $disk->url($path);
        }

        return Imgproxy::url($source, $options);
    }
}
