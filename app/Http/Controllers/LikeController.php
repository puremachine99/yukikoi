<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(Request $request, $koiId)
    {
        $user = auth()->user();

        // Cek apakah user sudah like
        $existingLike = Like::where('user_id', $user->id)->where('koi_id', $koiId)->first();

        if ($existingLike) {
            // Jika sudah like, hapus like (dislike)
            $existingLike->delete();

            // Hitung jumlah like terbaru
            $likesCount = Like::where('koi_id', $koiId)->count();

            return response()->json([
                'success' => true,
                'liked' => false,
                'likes_count' => $likesCount,
            ]);
        }

        // Jika belum like, tambahkan like
        Like::create([
            'user_id' => $user->id,
            'koi_id' => $koiId,
        ]);

        // Hitung jumlah like terbaru
        $likesCount = Like::where('koi_id', $koiId)->count();

        return response()->json([
            'success' => true,
            'liked' => true,
            'likes_count' => $likesCount,
        ]);
    }
}
