<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Koi;
use App\Models\User;
use App\Models\Ember;
use App\Models\Auction;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Services\KoiEnricher;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    public function userAuctions()
    {
        $userId = Auth::id();

        // Ambil semua lelang milik user yang sedang login
        $auctions = Auction::with([
            'koi.bids.user', // Ambil koi, bids, dan user yang bid
        ])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('auctions.user', compact('auctions'));
    }

    public function recap($auction_code)
    {
        $auction = Auction::with(['koi.bids.user', 'koi.media'])
            ->where('auction_code', $auction_code)
            ->firstOrFail();


        $kois = $auction->koi;

        // Hitung statistik lelang
        $totalBids = 0;
        $totalParticipants = [];
        $totalRevenue = 0;

        foreach ($kois as $koi) {
            $koi->total_bids = $koi->bids->count();
            $koi->latest_bid = $koi->bids->max('amount');
            $koi->winner = $koi->bids->where('is_win', true)->first();

            // Kumpulkan semua user yang melakukan bid
            foreach ($koi->bids as $bid) {
                $totalParticipants[$bid->user_id] = $bid->user->name ?? 'Guest';
            }

            $totalBids += $koi->total_bids;
            $totalRevenue += $koi->latest_bid ?? 0;
        }

        // Konversi ke collection
        $totalParticipants = collect($totalParticipants);

        return view('auctions.recap', compact('auction', 'kois', 'totalBids', 'totalParticipants', 'totalRevenue'));
    }


    // AuctionController.php
    public function checkStatus()
    {
        // Mengambil status dan auction_code dari database
        $auctions = Auction::select('auction_code', 'status')->get();
        return view('test', compact('auctions'));
    }

    public function fetchAuctions(Request $request)
    {
        $query = Auction::query();

        // Filter status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter kategori
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }

        // Filter search
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Sorting
        if ($request->has('sort')) {
            $query->orderBy('created_at', $request->sort);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Pagination
        $auctions = $query->paginate(6);

        return view('auctions.partials.list', compact('auctions'))->render();
    }

    public function startAuction($auction_code)
    {
        $auction = Auction::where('auction_code', $auction_code)->firstOrFail();

        // Ubah status dari 'draft' menjadi 'ready'
        if ($auction->status === 'draft') {
            $auction->status = 'ready';
            $auction->save();
        }

        return redirect()->route('auctions.index')->with('success', 'Lelang berhasil dimulai!');
    }

    public function onGoingAuctions()
    {
        // Ambil semua lelang dengan status 'on going'
        $auctions = Auction::where('status', 'on going')->get();

        // Kembalikan view dengan data lelang yang sedang berlangsung
        return view('auctions.ongoing', compact('auctions'));
    }

    public function index(Request $request)
    {
        // Ambil hanya lelang milik user yang sedang login
        $query = Auction::withCount('koi') // <--- hitung total koi per lelang
            ->with('user') // <--- load user kalau diperlukan di blade
            ->where('user_id', Auth::id());

        // Filter search berdasarkan title atau description
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter berdasarkan jenis
        if ($request->filled('jenis') && $request->jenis !== 'all') {
            $query->where('jenis', $request->jenis);
        }

        // Filter berdasarkan status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Sorting
        $query->orderBy('created_at', $request->get('sort', 'desc'));

        // Pagination
        $auctions = $query->paginate(8);

        return view('auctions.index', compact('auctions'));
    }

    public function create()
    {
        return view('auctions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'jenis' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Proses upload banner jika ada file yang diunggah
        $bannerPath = $request->hasFile('banner') ? $request->file('banner')->store('banner_auctions', 'public') : null;

        // Tentukan prefix berdasarkan jenis lelang
        $prefix = match ($request->input('jenis')) {
            'reguler' => 'RG',
            'azukari' => 'AZ',
            'keeping_contest' => 'KC',
            'grow_out' => 'GO',
            default => 'XX',
        };

        // Format untuk tahun dan bulan
        $tahunBulan = date('ym');

        // Generate nomor urut auction berdasarkan jenis dan tanggal
        $maxAuction = Auction::where('jenis', $request->input('jenis'))
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->max('auction_code');

        // Ambil nomor urut dari kode lelang terakhir (3 digit terakhir)
        $nomorUrut = $maxAuction ? intval(substr($maxAuction, -3)) + 1 : 1;
        $formattedUrut = str_pad($nomorUrut, 3, '0', STR_PAD_LEFT);

        // Buat kode lelang (auction_code)
        $auctionCode = $prefix . $tahunBulan . $formattedUrut;

        // Simpan data lelang ke database
        Auction::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'jenis' => $request->input('jenis'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'status' => 'draft',
            'auction_code' => $auctionCode, // Set auction_code di sini
            'banner' => $bannerPath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('auctions.index')->with('success', 'Auction created successfully!');
    }

    // public function show($auction_code)
    // {
    //     $auction = Auction::where('auction_code', $auction_code)
    //         ->with([
    //             'user',
    //             'koi.bids.user',
    //             'koi.media', // Eager load media
    //             'koi.certificates' // Eager load certificates
    //         ])
    //         ->firstOrFail();

    //     // Ambil data koi dari lelang yang sedang berlangsung
    //     $kois = $auction->koi;

    //     // Ambil user ID yang sedang login
    //     $user_id = Auth::id();

    //     // Ambil koi yang sudah di-mark oleh user (Ember)
    //     $ember = Ember::where('user_id', $user_id)->pluck('koi_id')->toArray();

    //     // Hitung total bid dan informasi pemenang untuk setiap koi
    //     $totalBids = $kois->mapWithKeys(function ($koi) {
    //         $winnerBid = $koi->bids->firstWhere('is_win', true); // Ambil bid yang menjadi pemenang

    //         return [
    //             $koi->id => [
    //                 'total_bids' => $koi->bids->count(),
    //                 'latest_bid' => $koi->bids->isNotEmpty() ? $koi->bids->first()->amount : $koi->open_bid,
    //                 'has_winner' => $winnerBid ? true : false,
    //                 'winner_name' => $winnerBid ? $winnerBid->user->name : null,
    //             ]
    //         ];
    //     });

    //     // Ambil history bids dari setiap koi
    //     $bidsHistory = $kois->mapWithKeys(function ($koi) {
    //         return [
    //             $koi->id => [
    //                 'koi_title' => $koi->judul,
    //                 'bids' => $koi->bids->take(5)->reverse()->map(function ($bid) {
    //                     return [
    //                         'user_phone' => substr($bid->user->phone_number, 0, 5) . 'XXX',
    //                         'amount' => number_format($bid->amount, 0, ',', '.'),
    //                         'created_at' => \Carbon\Carbon::parse($bid->created_at)->format('d M Y, H:i'),
    //                         'increment' => $bid->increment > 0 ? '+' . number_format($bid->increment, 0, ',', '.') : '[OB]',
    //                     ];
    //                 })
    //             ]
    //         ];
    //     });

    //     return view('auctions.show', compact('kois', 'auction', 'auction_code', 'ember', 'bidsHistory', 'totalBids'));
    // }

    /**
     * Show the form for editing the specified resource.
     */

    public function show($auction_code, KoiEnricher $enricher)
    {
        $auction = Auction::where('auction_code', $auction_code)
            ->with('user') // cukup user aja, kois nanti lewat relasi
            ->firstOrFail();

        $userId = Auth::id();

        $kois = $enricher->getAuctionKois($auction, $userId);
        $wishlist = Wishlist::where('user_id', $userId)->pluck('koi_id')->toArray();
        return view('auctions.show', compact('auction', 'kois', 'auction_code', 'wishlist'));
    }

    public function edit($auctionCode)
    {
        // Cari auction berdasarkan auction_code
        $auction = Auction::where('auction_code', $auctionCode)->firstOrFail();

        // Pastikan user yang sedang login adalah pemilik lelang
        if (Auth::id() !== $auction->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('auctions.edit', compact('auction'));
    }

    public function update(Request $request, $auctionCode)
    {
        $auction = Auction::where('auction_code', $auctionCode)->firstOrFail();

        // Pastikan user yang sedang login adalah pemilik lelang
        if (Auth::id() !== $auction->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi data dari request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            'contest_time' => 'nullable|date',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Cek jika end_time tidak diisi, otomatis tambahkan 24 jam dari start_time
        if (empty($validated['end_time'])) {
            $validated['end_time'] = \Carbon\Carbon::parse($validated['start_time'])->addDay();
        }

        // Proses upload banner jika ada
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('banners', $filename, 'public');
            $validated['banner'] = $path;
        }

        // Update data lelang
        $auction->update($validated);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('auctions.index')->with('success', 'Lelang berhasil diperbarui!');
    }

    public function destroy($auctionCode)
    {
        $auction = Auction::where('auction_code', $auctionCode)->firstOrFail();

        // Pastikan user yang sedang login adalah pemilik lelang
        if (Auth::id() !== $auction->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $auction->delete();
        return response()->json(['success' => 'Lelang berhasil dihapus.']);
    }
}
