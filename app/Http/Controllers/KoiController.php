<?php

namespace App\Http\Controllers;

use App\Models\Koi;
use App\Models\Media;
use App\Models\Auction;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($auction_code)
    {
        // Ambil data auction berdasarkan auction_code
        $auction = Auction::where('auction_code', $auction_code)->firstOrFail();

        // Ambil koi berdasarkan auction_code
        $kois = Koi::where('auction_code', $auction_code)->get();

        // Kembalikan view dengan data koi, baik ada data maupun tidak
        return view('koi.index', compact('kois', 'auction', 'auction_code'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $auction_code = $request->auction_code;

        $auction = Auction::where('auction_code', $auction_code)->firstOrFail();
        $existingKoisCount = Koi::where('auction_code', $auction_code)->count();
        $newKoiCode = $this->getKoiCode($existingKoisCount);

        return view('koi.create', compact('auction_code', 'auction', 'newKoiCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|array',
            'jenis_koi' => 'required|array',
            'ukuran' => 'required|array',
            'gender' => 'required|array',
            'open_bid' => 'required|array',
            'kelipatan_bid' => 'required|array',
            'buy_it_now' => 'array',
            'keterangan' => 'required|array',
            'breeder' => 'required|array',
            'video_koi.*' => 'nullable|mimes:mp4,mov,ogg|max:20000',
            'gambar_koi.*.*' => 'nullable|image|max:2048',
            'sertifikat_koi.*.*' => 'nullable|image|max:2048',
        ]);

        // Ambil semua kode koi yang sudah ada di dalam lelang ini
        $existingKois = Koi::where('auction_code', $request->auction_code)
            ->orderBy('kode_ikan') // Urutkan berdasarkan kode ikan
            ->pluck('kode_ikan')->toArray(); // Hanya ambil kode ikannya dalam bentuk array

        // Ambil kode yang hilang (misalnya jika kode A, B, D ada, kode C hilang)
        $availableKoiCodes = $this->findAvailableKoiCodes($existingKois, count($request->jenis_koi));

        foreach ($request->jenis_koi as $index => $jenisKoi) {
            // Ambil kode ikan dari daftar yang tersedia (termasuk kode yang hilang)
            $kodeIkan = array_shift($availableKoiCodes); // Ambil kode yang pertama dari availableKoiCodes

            // Generate ID Koi dari gabungan auction_code dan kode_ikan
            $id_koi = $request->auction_code . $kodeIkan;

            Koi::create([
                'id' => $id_koi,
                'auction_code' => $request->auction_code,
                'kode_ikan' => $kodeIkan,
                'judul' => $request->judul[$index], // Penambahan untuk kolom judul
                'jenis_koi' => $jenisKoi,
                'ukuran' => $request->ukuran[$index],
                'gender' => $request->gender[$index],
                'open_bid' => $request->open_bid[$index],
                'kelipatan_bid' => $request->kelipatan_bid[$index],
                'buy_it_now' => $request->buy_it_now[$index] ?? null,
                'keterangan' => $request->keterangan[$index],
                'breeder' => $request->breeder[$index],
            ]);

            // Simpan media koi (foto/video) ke tabel media, jika ada
            if ($request->hasFile("video_koi.{$index}")) {
                $videoPath = $request->file("video_koi.{$index}")->store('koi_videos', 'public');
                Media::create([
                    'koi_id' => $id_koi,
                    'url_media' => $videoPath,
                    'media_type' => 'video'
                ]);
            }

            if ($request->hasFile("gambar_koi.{$index}")) {
                foreach ($request->file("gambar_koi.{$index}") as $gambarKoi) {
                    $imagePath = $gambarKoi->store('koi_images', 'public');
                    Media::create([
                        'koi_id' => $id_koi,
                        'url_media' => $imagePath,
                        'media_type' => 'photo'
                    ]);
                }
            }

            // Simpan sertifikat koi (jika ada)
            if ($request->hasFile("sertifikat_koi.{$index}")) {
                foreach ($request->file("sertifikat_koi.{$index}") as $sertifikatKoi) {
                    $certificatePath = $sertifikatKoi->store('koi_certificates', 'public');
                    Certificate::create([
                        'koi_id' => $id_koi,
                        'url_gambar' => $certificatePath
                    ]);
                }
            }
        }

        return redirect()->route('koi.index', ['auction_code' => $request->auction_code])
                     ->with('success', 'Data Koi berhasil disimpan!');
    }

    /**
     * Fungsi untuk menemukan kode Koi yang tersedia berdasarkan kode yang sudah ada
     */
    private function findAvailableKoiCodes($existingKois, $newKoiCount)
    {
        $availableKoiCodes = [];

        // Cek kode dari A hingga Z, AA hingga ZZ, dst.
        $index = 0;
        $maxIndex = 26;

        while (count($availableKoiCodes) < $newKoiCount) {
            // Hitung kode ikan saat ini (misal A, B, C, dst.)
            $kodeIkan = '';
            $currentIndex = $index;

            while ($currentIndex >= 0) {
                $kodeIkan = chr(65 + ($currentIndex % 26)) . $kodeIkan;
                $currentIndex = intdiv($currentIndex, 26) - 1;
            }

            // Jika kode ikan ini belum ada dalam existingKois, tambahkan ke daftar
            if (!in_array($kodeIkan, $existingKois)) {
                $availableKoiCodes[] = $kodeIkan;
            }

            $index++;
        }

        return $availableKoiCodes;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data koi berdasarkan ID
        $koi = Koi::findOrFail($id);

        // Kembalikan view untuk edit dengan data koi
        return view('koi.edit', compact('koi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'jenis_koi' => 'required|string|max:255',
            'ukuran' => 'required|integer',
            'gender' => 'required|string',
            'open_bid' => 'required|integer',
            'kelipatan_bid' => 'required|integer',
            'buy_it_now' => 'nullable|integer',
            'keterangan' => 'nullable|string',
            'breeder' => 'nullable|string|max:255',
        ]);

        $koi = Koi::findOrFail($id);
        $koi->update($request->all());

        return redirect()->route('koi.index', ['auction_code' => $koi->auction_code])
            ->with('success', 'Koi berhasil diupdate.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $koi = Koi::find($id);

        if ($koi && Auth::id() === $koi->auction->user_id) {
            $koi->media()->delete();
            $koi->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Koi not found or unauthorized']);
    }

    private function getKoiCode($index)
    {
        $code = '';
        while ($index >= 0) {
            $code = chr($index % 26 + 65) . $code;
            $index = intval($index / 26) - 1;
        }
        return $code;
    }
}
