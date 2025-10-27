<?php

namespace App\Http\Controllers;

use App\Support\Media;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MediaProxyController extends Controller
{
    public function __invoke(Request $request, string $path)
    {
        $localPath = public_path('storage/' . $path);

        if (file_exists($localPath)) {
            return Response::file($localPath, [
                'Cache-Control' => 'public, max-age=604800',
            ]);
        }

        $width = (int) $request->query('w', 0);
        $height = (int) $request->query('h', 0);
        $enlarge = (int) $request->query('enlarge', 1);

        $options = [];

        if ($width > 0 || $height > 0) {
            $options['resize'] = ['fill', $width, $height, $enlarge];
        }

        $proxyUrl = Media::url($path, $options);

        return new RedirectResponse($proxyUrl, 302, [
            'Cache-Control' => 'public, max-age=60',
        ]);
    }
}

