<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Koi;
use App\Models\User;
use App\Models\Event;
use App\Models\Wishlist;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\KoiEnricher;
class LiveAuctionController extends Controller
{

    public function index(Request $request, KoiEnricher $enricher)
    {
        $userId = Auth::id();

        $kois = $enricher->getLiveAuctionKois($request, $userId);

        $wishlist = Wishlist::where('user_id', $userId)->pluck('koi_id')->toArray();

        return view('live.index', compact('kois', 'wishlist'));
    }
}
