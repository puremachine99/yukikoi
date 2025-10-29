<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmBinRequest;
use App\Http\Requests\StoreBidRequest;
use App\Models\Bid;
use App\Models\Wishlist;
use App\Services\BidPlacementService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class BidController extends Controller
{
    public function __construct(private readonly BidPlacementService $placementService)
    {
    }

    public function userBids(Request $request)
    {
        $userId = Auth::id();

        // Rate limiter cek gak abuse pas request
        $key = 'user-bids:' . $userId;
        if (RateLimiter::tooManyAttempts($key, 30)) {
            return response()->json([
                'success' => false,
                'message' => 'Terlalu banyak permintaan, coba lagi dalam beberapa saat.'
            ], 429);
        }
        RateLimiter::hit($key, 60); // decay 60 detik

        // Ambil semua bid user (relasi koi.auction, koi.bids difilter ke user ini)
        $bids = Bid::with([
            'koi.auction',
            'koi.bids' => function ($query) use ($userId) {
                $query->where('user_id', $userId)->orderBy('created_at', 'desc');
            },
            'koi.media' => function ($query) {
                $query->where('media_type', 'photo');
            }
        ])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil wishlist user (tambahkan koi.bids supaya aman dipakai di view)
        $wishlists = Wishlist::with([
            'koi.auction',
            'koi.bids', // penting agar komponen tidak n+1 / null
            'koi.media' => function ($query) {
                $query->where('media_type', 'photo');
            }
        ])
            ->where('user_id', $userId)
            ->get();

        // Gabungkan bid dan wishlist berdasarkan koi_id agar tidak duplikat
        $kois = collect([...$bids, ...$wishlists])
            ->groupBy('koi_id')
            ->map(function ($items) {
                return $items->sortByDesc('created_at')->first();
            });

        // Ambil bid terakhir (global) per koi yang masih "on going"
        $latestBids = Bid::with(['koi.auction', 'user'])
            ->whereHas('koi.auction', function ($query) {
                $query->where('status', 'on going');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('koi_id')
            ->map(fn($bids) => $bids->sortByDesc('created_at')->first());

        // Pemenang (is_win = true)
        $winners = $latestBids->filter(fn($bid) => $bid && $bid->is_win);

        return view('bids.index', compact(['kois', 'latestBids', 'winners']));
    }

    public function confirmPin(Request $request)
    {
        $request->validate([
            'koi_id' => 'required|exists:kois,id',
            'pin'    => 'required|numeric|digits:4',
        ]);

        $user = Auth::user();
        $inputPin = $request->input('pin');

        if ($user->pin !== $inputPin) {
            return response()->json(['success' => false, 'message' => 'PIN salah'], 400);
        }

        return response()->json(['success' => true, 'message' => 'PIN valid']);
    }

    public function confirmBIN(ConfirmBinRequest $request)
    {
        try {
            $result = $this->placementService->confirmBuyNow($request->user(), $request->validated('koi_id'));
        } catch (AuthorizationException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], Response::HTTP_FORBIDDEN);
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'errors' => $exception->errors(),
            ], Response::HTTP_BAD_REQUEST);
        } catch (Throwable $throwable) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan ketika memproses BIN.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success' => true,
            'message' => 'BIN berhasil, koi telah dimasukkan ke keranjang',
            'cart' => $result['cart'],
            'bid' => $result['bid'],
        ]);
    }

    public function store(StoreBidRequest $request)
    {
        $key = 'bid-action:' . Auth::id();
        $bid_attempt = 10;

        if (RateLimiter::tooManyAttempts($key, $bid_attempt)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => "Anda telah mencapai batas bid. Coba lagi dalam $seconds detik.",
            ], 429);
        }

        try {
            $result = $this->placementService->placeBid(
                $request->user(),
                $request->validated('koi_id'),
                (int) $request->validated('bid_amount')
            );
        } catch (AuthorizationException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], Response::HTTP_FORBIDDEN);
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'errors' => $exception->errors(),
            ], Response::HTTP_BAD_REQUEST);
        } catch (Throwable $throwable) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memasang bid.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        RateLimiter::hit($key);

        return response()->json([
            'success' => true,
            'message' => 'Bid berhasil dipasang',
            'bid' => $result['bid'],
            'end' => $result['end_time']->toDateTimeString(),
            'isSniping' => $result['is_sniping'],
            'remainingTime' => $result['remaining_time'],
            'extraTime' => $result['auction']->extra_time,
        ]);
    }
}
