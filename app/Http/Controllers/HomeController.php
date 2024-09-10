<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Ambil lelang yang sedang berlangsung
        $query = Auction::where('status', 'on going');

        // Jika ada input pencarian, filter berdasarkan title atau user farm name
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('title', 'like', "%$search%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('farm_name', 'like', "%$search%");
                  });
        }

        $auctions = $query->get();

        // Kirimkan data ke view
        return view('home', compact('auctions'));
    }
}
