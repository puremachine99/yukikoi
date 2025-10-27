<?php

namespace App\Support;

use Illuminate\Support\Str;

class Imgproxy
{
    public static function url(string $sourceUrl, array $options = []): string
    {
        $baseUrl = rtrim((string) config('imgproxy.url'), '/');
        $path = self::buildProcessingPath($sourceUrl, $options);

        $hasSigningSecrets = config('imgproxy.key') && config('imgproxy.salt');
        $shouldSign = config('imgproxy.should_sign') && $hasSigningSecrets;

        if ($shouldSign) {
            $signature = self::signature($path);
            return sprintf('%s/%s/%s', $baseUrl, $signature, ltrim($path, '/'));
        }

        if (config('imgproxy.allow_insecure')) {
            return sprintf('%s/%s/%s', $baseUrl, 'insecure', ltrim($path, '/'));
        }

        // Fallback to direct storage URL when insecure links are disabled
        return self::resolveSourceUrl($sourceUrl);
    }

    protected static function buildProcessingPath(string $sourceUrl, array $options): string
    {
        $defaults = config('imgproxy.default_options', []);
        $options = array_replace_recursive($defaults, $options);

        $segments = [];

        if (!empty($options['resize'])) {
            [$type, $width, $height, $enlarge] = array_pad($options['resize'], 4, null);
            $segments[] = sprintf('rs:%s:%s:%s:%s', $type ?? 'fill', $width ?? 0, $height ?? 0, $enlarge ?? 1);
        }

        if (!empty($options['quality'])) {
            $segments[] = 'q:' . (int) $options['quality'];
        }

        if (!empty($options['format'])) {
            $segments[] = 'f:' . $options['format'];
        }

        if (!empty($options['dpr'])) {
            $segments[] = 'dpr:' . $options['dpr'];
        }

        $encodedUrl = self::encodeUrl(self::resolveSourceUrl($sourceUrl));

        $segments[] = 'plain';

        $segments[] = $encodedUrl;

        return implode('/', $segments);
    }

    protected static function resolveSourceUrl(string $url): string
    {
        $base = config('imgproxy.source_url_base');

        if ($base && Str::startsWith($url, ['/', '\\'])) {
            return rtrim($base, '/') . '/' . ltrim($url, '/');
        }

        return $url;
    }

    protected static function encodeUrl(string $url): string
    {
        return 'base64:' . rtrim(strtr(base64_encode($url), '+/', '-_'), '=');
    }

    protected static function signature(string $path): string
    {
        $key = pack('H*', config('imgproxy.key'));
        $salt = pack('H*', config('imgproxy.salt'));
        $hash = hash_hmac('sha256', $salt . $path, $key, true);

        return rtrim(strtr(base64_encode($hash), '+/', '-_'), '=');
    }
}
