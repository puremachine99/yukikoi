<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Koi;
use App\Models\User;
use App\Models\Rating;
use App\Models\Auction;
use Illuminate\View\View;
use App\Models\Certificate;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\KoiEnricher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Wishlist;

class ProfileController extends Controller
{
    public function becomeSeller(Request $request)
    {
        $user = $request->user();
        $user->is_seller = true;
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'Anda sekarang menjadi seller!');
    }

    public function index(): RedirectResponse
    {

        $user = Auth::user();
        return Redirect::route('profile.show', $user->id);
    }

    public function show($id, KoiEnricher $enricher)
    {
        // Ambil user yang dimaksud
        $user = User::with('auctions')->findOrFail($id);

        $userId = Auth::id();

        // Ambil semua auction milik user (user sebagai seller)
        $auctions = Auction::with('koi')
            ->where('user_id', $user->id)
            ->whereIn('status', ['on going', 'ready', 'completed'])
            ->get();

        // Ambil koi dari semua auction tersebut
        $kois = $auctions->pluck('koi')->flatten();

        // Gunakan KoiEnricher untuk memperkaya data koi (wishlist, likes, rating seller, dll)
        $kois = $enricher->enrichCollection($kois, $userId);

        // Hitung total bid dan info pemenang untuk tiap koi
        $totalBids = $kois->mapWithKeys(function ($koi) {
            $winnerBid = $koi->bids->firstWhere('is_win', true);

            return [
                $koi->id => [
                    'total_bids' => $koi->bids->count(),
                    'latest_bid' => $koi->bids->first()?->amount ?? $koi->open_bid,
                    'has_winner' => (bool) $winnerBid,
                    'winner_name' => $winnerBid?->user->name,
                ]
            ];
        });

        // Hitung total profit dari tiap auction
        $auctions = $auctions->map(function ($auction) {
            $totalProfit = $auction->koi->sum(fn($koi) => $koi->bids->first()?->amount ?? 0);
            $auction->total_profit = $totalProfit;
            return $auction;
        });

        // Statistik user
        $userStats = [
            'lelang_dibuat' => Auction::where('user_id', $user->id)->count(),
            'lelang_diikuti' => Bid::where('user_id', $user->id)->whereHas('koi.auction')->distinct('koi_id')->count(),
            'koi_dimenangkan' => Bid::where('user_id', $user->id)->where('is_win', true)->count(),
            'jumlah_koi' => $kois->count(),
            'jumlah_sertifikat' => Certificate::whereHas('koi.auction', fn($q) => $q->where('user_id', $user->id))->count(),
            'jumlah_pengeluaran' => Bid::where('user_id', $user->id)->where('is_win', true)->sum('amount'),

            // Tambahan statistik
            'koi_terdaftar' => Koi::whereHas('auction', fn($q) => $q->where('user_id', $user->id))->count(),
            'koi_terlelang' => Bid::whereHas('koi.auction', fn($q) => $q->where('user_id', $user->id))->where('is_win', true)->count(),
            'jumlah_pendapatan' => Bid::whereHas('koi.auction', fn($q) => $q->where('user_id', $user->id))->sum('amount'),
            'jumlah_kontest_diikuti' => Auction::where('user_id', $user->id)->whereIn('jenis', ['keeping_contest', 'grow_out'])->count(),
            'jumlah_sniping' => Bid::where('user_id', $user->id)->where('is_sniping', true)->count(),
            'jumlah_menang_sniping' => Bid::where('user_id', $user->id)->where('is_win', true)->where('is_sniping', true)->count(),
        ];

        // Rating seller
        $ratings = Rating::where('seller_id', $user->id)
            ->selectRaw('seller_id, 
                AVG(rating_quality) as avg_quality, 
                AVG(rating_shipping) as avg_shipping, 
                AVG(rating_service) as avg_service, 
                (AVG(rating_quality) + AVG(rating_shipping) + AVG(rating_service)) / 3 as overall_rating')
            ->groupBy('seller_id')
            ->first();

        $wishlist = Wishlist::where('user_id', $userId)->pluck('koi_id')->toArray();

        return view('profile.show', compact(
            'user',
            'kois',
            'auctions',
            'totalBids',
            'userStats',
            'ratings',
            'wishlist'
        ));

    }



    public function edit(Request $request): View
    {
        $user = $request->user();
        $addresses = $user->addresses; // Pastikan relasi sudah ada di model User

        return view('profile.edit', compact('user', 'addresses'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Handle KTP Photo upload jika ada
        if ($request->hasFile('ktp_photo')) {
            if ($user->ktp_photo) {
                Storage::disk('public')->delete($user->ktp_photo);
            }
            $ktpFile = $request->ktp_photo->store('ktp_photos', 'public');
        } else {
            $ktpFile = $user->ktp_photo;
        }

        // Handle Profile Photo upload
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $profileFile = $request->profile_photo->store('profile_photos', 'public');
        } else {
            $profileFile = $user->profile_photo;
        }

        // Update user information, including bio and social contacts
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'farm_name' => $request->farm_name,
            'address' => $request->address,
            'city' => $request->city,
            'phone_number' => $request->phone_number,
            'nik' => $request->nik,
            'ktp_photo' => $ktpFile,
            'profile_photo' => $profileFile,
            'bio' => $request->bio,
            'whatsapp' => $request->whatsapp,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
        ]);

        // Reset email_verified_at jika email diubah
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }



    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
