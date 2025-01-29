<?php
namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Koi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Tambahkan item ke wishlist
    public function toggle(Request $request)
    {
        $request->validate([
            'koi_id' => 'required|exists:kois,id'
        ]);

        $userId = Auth::id();
        $koiId = $request->input('koi_id');

        $wishlist = Wishlist::where('user_id', $userId)->where('koi_id', $koiId)->first();

        if ($wishlist) {
            // Hapus dari wishlist jika sudah ada
            $wishlist->delete();
            return response()->json([
                'success' => true,
                'message' => 'Koi dihapus dari wishlist',
                'wishlisted' => false
            ]);
        } else {
            // Tambahkan ke wishlist
            Wishlist::create([
                'user_id' => $userId,
                'koi_id' => $koiId
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Koi ditambahkan ke wishlist',
                'wishlisted' => true
            ]);
        }
    }

    // Ambil semua wishlist user
    public function index()
    {
        $userId = Auth::id();
        $wishlists = Wishlist::with('koi')->where('user_id', $userId)->get();

        return view('wishlist.index', compact('wishlists'));
    }
}
