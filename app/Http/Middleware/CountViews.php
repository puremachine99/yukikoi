<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Lihat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CountViews
{
    public function handle(Request $request, Closure $next)
    {
        // get koi_id dari route parameter
        $koiId = $request->route('id');

        // gak login gak kecatet
        $userId = Auth::check() ? Auth::id() : null;

        // Cek apakah sudah ada record di tabel 'lihats' untuk user dan koi ini
        if (!Lihat::where('user_id', $userId)->where('koi_id', $koiId)->exists()) {
            // Tambahkan data baru ke tabel lihats
            Lihat::create([
                'user_id' => $userId,
                'koi_id' => $koiId,
            ]);
        }

        return $next($request);
    }
}
