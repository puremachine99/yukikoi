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
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

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

    public function show($id)
    {
        // Ambil user beserta auctions, kois, bids, dan media dengan eager loading
        $user = User::with([
            'auctions.koi.media' => function ($query) {
                $query->where('media_type', 'photo'); // Hanya media yang berupa foto
            },
            'auctions.koi.bids' => function ($query) {
                $query->latest(); // Urutkan bid dari yang terakhir
            }
        ])->findOrFail($id);

        // Ambil semua lelang yang dimiliki oleh user
        $auctions = $user->auctions;

        // Eager load koi, media, dan bids untuk lelang yang dimiliki user
        $kois = Koi::whereHas('auction', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->whereIn('status', ['on going', 'ready', 'completed']); // Filter status lelang
        })->with([
                    'media' => function ($query) {
                        $query->where('media_type', 'photo'); // Hanya media yang berupa foto
                    },
                    'bids' => function ($query) {
                        $query->latest(); // Urutkan bid dari yang terakhir
                    }
                ])->get();

        // Hitung total bid dan informasi pemenang untuk setiap koi
        $totalBids = $kois->mapWithKeys(function ($koi) {
            $winnerBid = $koi->bids->firstWhere('is_win', true); // Ambil bid yang menjadi pemenang

            return [
                $koi->id => [
                    'total_bids' => $koi->bids->count(),
                    'latest_bid' => $koi->bids->isNotEmpty() ? $koi->bids->first()->amount : $koi->open_bid,
                    'has_winner' => $winnerBid ? true : false,
                    'winner_name' => $winnerBid ? $winnerBid->user->name : null,
                ]
            ];
        });

        // Hitung total keuntungan per auction berdasarkan latest_bid dari tiap koi
        $auctions = $auctions->map(function ($auction) {
            $totalProfit = $auction->koi->sum(function ($koi) {
                if ($koi->bids->isNotEmpty()) {
                    return optional($koi->bids->first())->amount ?? 0;
                }
                return 0;
            });
            $auction->total_profit = $totalProfit;
            return $auction;
        });

        // Statistik user (misalnya, ini untuk ditampilkan di view)
        $userStats = [
            'lelang_dibuat' => Auction::where('user_id', $user->id)->count(),
            'lelang_diikuti' => Bid::where('user_id', $user->id)
                ->whereHas('koi.auction')
                ->distinct('koi_id')
                ->count(), // Jumlah lelang yang diikuti user
            'koi_dimenangkan' => Bid::where('user_id', $user->id)
                ->where('is_win', true)
                ->count(), // Jumlah koi yang dimenangkan
            'jumlah_koi' => $kois->count(), // Jumlah koi yang dimiliki user
            'jumlah_sertifikat' => Certificate::whereHas('koi.auction', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count(), // Jumlah sertifikat koi
            'jumlah_pengeluaran' => Bid::where('user_id', $user->id)
                ->where('is_win', true)
                ->sum('amount'), // Total uang yang dihabiskan untuk membeli koi

            // Tambahan statistik
            'koi_terdaftar' => Koi::whereHas('auction', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count(), // Jumlah koi terlelang
            'koi_terlelang' => Bid::whereHas('koi.auction', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('is_win', true)->count(), // Jumlah koi terlelang

            'jumlah_pendapatan' => Bid::whereHas('koi.auction', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->sum('amount'), // Jumlah total pendapatan dari lelang

            'jumlah_kontest_diikuti' => Auction::where('user_id', $user->id)
                ->whereIn('jenis', ['keeping_contest', 'grow_out'])
                ->count(), // Jumlah kontes (KC/GO) yang diikuti

            'jumlah_sniping' => Bid::where('user_id', $user->id)
                ->where('is_sniping', true)
                ->count(), // Jumlah bid yang dilakukan dalam waktu sniping

            'jumlah_menang_sniping' => Bid::where('user_id', $user->id)
                ->where('is_win', true)
                ->where('is_sniping', true)
                ->count(), // Jumlah menang bid dalam waktu sniping
        ];
        // Ambil rata-rata rating seller
        $ratings = Rating::where('seller_id', $user->id)
            ->selectRaw('seller_id, 
                 AVG(rating_quality) as avg_quality, 
                 AVG(rating_shipping) as avg_shipping, 
                 AVG(rating_service) as avg_service, 
                 (AVG(rating_quality) + AVG(rating_shipping) + AVG(rating_service)) / 3 as overall_rating')
            ->groupBy('seller_id')
            ->first();

        // Kirim data ke view
        return view('profile.show', compact('user', 'kois', 'auctions', 'totalBids', 'userStats', 'ratings'));
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
