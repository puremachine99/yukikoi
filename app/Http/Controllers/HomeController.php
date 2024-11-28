<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Carbon\Carbon;
use App\Models\Auction;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $currentTime = Carbon::now();
    
        // Get auctions that are 'on going' or are 'ready' and starting within an hour
        $auctions = Auction::with(['user', 'koi']) // eager load to prevent N+1
            ->where('status', 'on going')
            ->orWhere(function ($query) use ($currentTime) {
                $query->where('status', 'ready')
                      ->where('start_time', '>=', $currentTime)
                      ->where('start_time', '<=', $currentTime->copy()->addDay()); // Within a day
            })
            ->get();
    
        // Fetch carousel ads
        $carouselAds = Ad::where('position', 'carousel')
                         ->where('is_active', true)
                         ->get();
    
        // Pass both auctions and carousel ads to the view
        return view('home', compact('auctions', 'carouselAds'));
    }
}
