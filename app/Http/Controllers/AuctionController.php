<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Koi;
use App\Models\User;
use App\Models\Auction;
use App\Models\MarkedKoi;
use Illuminate\Http\Request;
use App\Jobs\UpdateAuctionStatus;
use App\Models\Ember;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{

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
        $query = Auction::where('user_id', Auth::id());

        // Filter search berdasarkan title atau description
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan jenis
        if ($request->has('jenis') && $request->jenis != 'all') {
            $query->where('jenis', $request->jenis);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Sorting
        if ($request->has('sort')) {
            $query->orderBy('created_at', $request->sort);
        } else {
            $query->orderBy('created_at', 'desc');
        }

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

    public function show($auction_code)
    {
        // Ambil data auction berdasarkan auction_code dan relasi ke user dan koi
        $auction = Auction::where('auction_code', $auction_code)
            ->with(['user', 'koi']) // Ambil relasi ke user dan koi
            ->firstOrFail();

        // Ambil data koi dari lelang yang sedang berlangsung
        $kois = $auction->koi;

        // Ambil user ID yang sedang login
        $user_id = Auth::id();

        // Ambil koi yang sudah di-mark oleh user
        $ember = Ember::where('user_id', $user_id)->pluck('koi_id')->toArray();

        // Kembalikan view dengan data auction, koi, dan user pemilik lelang
        return view('auctions.show', compact('kois', 'auction', 'auction_code','ember'));
    }
    /**
     * Show the form for editing the specified resource.
     */
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
