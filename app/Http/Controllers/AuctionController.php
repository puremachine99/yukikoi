<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    public function startAuction($id)
    {
        $auction = Auction::findOrFail($id);

        // Cek apakah lelang sudah memiliki koi
        if ($auction->koi()->count() == 0) {
            return response()->json(['error' => 'Lelang belum memiliki koi.'], 400);
        }

        // Cek waktu saat ini
        $currentTime = now();

        // Ubah status lelang berdasarkan waktu
        if ($auction->start_time > $currentTime) {
            // Waktu sekarang belum mencapai waktu mulai, status jadi 'ready'
            $auction->status = 'ready';
        } elseif ($auction->start_time <= $currentTime && $auction->end_time > $currentTime) {
            // Waktu sekarang di antara waktu mulai dan selesai, status 'on going'
            $auction->status = 'on going';
        } elseif ($auction->end_time <= $currentTime) {
            // Waktu sudah melewati waktu selesai, status jadi 'complete'
            $auction->status = 'complete';
        }

        // Simpan perubahan
        $auction->save();

        return response()->json(['success' => 'Lelang telah dimulai.']);
    }


    public function onGoingAuctions()
    {
        // Ambil semua lelang dengan status 'on going'
        $auctions = Auction::where('status', 'on going')->get();

        // Kembalikan view dengan data lelang yang sedang berlangsung
        return view('auctions.ongoing', compact('auctions'));
    }

    public function index()
    {
        $auctions = Auction::where('status', 'draft')->get();  // Menampilkan hanya draft
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
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('banner_auctions', 'public');
        } else {
            $bannerPath = null;
        }

        // Simpan data lelang ke database
        Auction::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'jenis' => $request->input('jenis'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),
            'status' => 'draft',
            'auction_code' => 'RG' . date('ymd') . str_pad(Auction::max('id') + 1, 3, '0', STR_PAD_LEFT),
            'banner' => $bannerPath,
            'user_id' => Auth::id(), // Pastikan user_id dimasukkan
        ]);

        return redirect()->route('auctions.index')->with('success', 'Auction created successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Auction $auction)
    {
        return view('auctions.show');
        // diisi list koi
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Auction $auction, $auctionCode)
    {
        $auction = Auction::where('auction_code', $auctionCode)->firstOrFail();

        return view('auctions.edit', compact('auction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $auctionCode)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'jenis' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            'contest_time' => 'nullable|date',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Validasi untuk banner
        ]);

        // Cek apakah end_time kosong
        if (empty($validated['end_time'])) {
            $validated['end_time'] = date('Y-m-d H:i:s', strtotime($validated['start_time'] . ' +1 day'));
        }

        // Cari lelang berdasarkan kode
        $auction = Auction::where('auction_code', $auctionCode)->firstOrFail();

        // Jika ada banner baru yang di-upload
        if ($request->hasFile('banner')) {
            $file = $request->file('banner');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('banners', $filename, 'public');
            $validated['banner'] = $path;
        }

        // Update data lelang
        $auction->update($validated);

        return redirect()->route('auctions.index')->with('success', 'Lelang berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auction $auction)
    {
        $auction->delete();
        return response()->json(['success' => 'Lelang berhasil dihapus.']);
    }
}
