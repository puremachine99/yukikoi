<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserActivityController extends Controller
{
    /**
     * Handle like and unlike activity for a koi.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $koiId
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleLike(Request $request, $koiId)
    {
        $user = Auth::user();

        // Cari aktivitas 'like' pada tabel activities
        $existingActivity = UserActivity::where('user_id', $user->id)
            ->where('koi_id', $koiId)
            ->where('activity_type', 'like')
            ->first();

        if ($existingActivity) {
            // Jika sudah like, hapus like (dislike)
            $existingActivity->delete();

            // Hitung jumlah like terbaru
            $likesCount = UserActivity::where('koi_id', $koiId)
                ->where('activity_type', 'like')
                ->count();

            return response()->json([
                'success' => true,
                'liked' => false,
                'likes_count' => $likesCount,
            ]);
        }

        // Jika belum like, tambahkan like
        UserActivity::create([
            'user_id' => $user->id,
            'koi_id' => $koiId,
            'activity_type' => 'like',
            'weight' => 2.0, // Set weight untuk preferensi algoritma
        ]);

        // Hitung jumlah like terbaru
        $likesCount = UserActivity::where('koi_id', $koiId)
            ->where('activity_type', 'like')
            ->count();

        return response()->json([
            'success' => true,
            'liked' => true,
            'likes_count' => $likesCount,
        ]);
    }

    public function view(Request $request, $koiId)
    {
        $user = Auth::user();

        // Cek apakah user sudah mengunjungi koi ini sebelumnya
        $existingView = UserActivity::where('user_id', $user->id ?? null)
            ->where('koi_id', $koiId)
            ->where('activity_type', 'view')
            ->first();

        if (!$existingView) {
            // Jika belum, tambahkan data view baru
            UserActivity::create([
                'user_id' => $user->id ?? null, // Bisa null jika user tidak login
                'koi_id' => $koiId,
                'activity_type' => 'view',
                'created_at' => now(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    
}
