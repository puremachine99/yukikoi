<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Auction;
use App\Support\CacheKeys;
use App\Support\Media;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $currentTime = Carbon::now();
    
        // Get auctions that are 'on going' or are 'ready' and starting within an hour
        $auctionCacheTtl = now()->addSeconds((int) config('cache_ttl.home_auctions', 60));
        $auctions = Cache::remember(CacheKeys::HOME_AUCTIONS, $auctionCacheTtl, function () use ($currentTime) {
            return Auction::with(['user', 'koi'])
                ->where('status', 'on going')
                ->orWhere(function ($query) use ($currentTime) {
                    $query->where('status', 'ready')
                        ->where('start_time', '>=', $currentTime)
                        ->where('start_time', '<=', $currentTime->copy()->addDay());
                })
                ->get();
        });

        $adsCacheTtl = now()->addSeconds((int) config('cache_ttl.home_carousel_ads', 60));
        $carouselAds = Cache::remember(CacheKeys::HOME_CAROUSEL_ADS, $adsCacheTtl, function () {
            return Ad::where('position', 'carousel')
                ->where('is_active', true)
                ->get();
        });

        $carouselSlides = $carouselAds->map(function ($ad) {
            return [
                'title' => $ad->title,
                'description' => $ad->description,
                'link' => $ad->link,
                'image' => Media::url($ad->image, [
                    'resize' => ['fill', 1600, 640, 1],
                    'quality' => 85,
                ]),
            ];
        });
    
        // Pass both auctions and carousel ads to the view
        return view('home', compact('auctions', 'carouselAds', 'carouselSlides'));
    }
}
