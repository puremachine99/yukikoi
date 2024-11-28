<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LihatController extends Controller
{
    public function view(Request $request, $koiId)
    {
        $userId = auth()->id();

        // Tambahkan view
        Lihat::create([
            'user_id' => $userId,
            'koi_id' => $koiId,
        ]);

        return response()->json(['message' => 'Koi view recorded.']);
    }
}
