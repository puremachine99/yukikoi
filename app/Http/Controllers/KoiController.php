<?php

namespace App\Http\Controllers;

use App\Models\Koi;
use App\Models\Media;
use App\Models\Auction;
use App\Models\Certificate;
use Illuminate\Http\Request;

class KoiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($auction_id)
    {
        $kois = Koi::with(['media', 'certificates'])->where('auction_id', $auction_id)->get();
        return view('koi.index', compact('kois', 'auction_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $auction_id = $request->auction_id; // Ambil dari query string
        $auction_code = $request->auction_code; // Ambil dari query string

        return view('koi.create', compact('auction_id', 'auction_code'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'kode_ikan' => 'required|array', // Validasi kode_ikan
            'jenis_koi' => 'required|array',
            'ukuran' => 'required|array',
            'gender' => 'required|array',
            'open_bid' => 'required|array',
            'kelipatan_bid' => 'required|array',
            'buy_it_now' => 'array',
            'video_koi.*' => 'nullable|mimes:mp4,mov,ogg|max:20000', // Aturan untuk video koi
            'gambar_koi.*.*' => 'nullable|image|max:2048', // Aturan untuk gambar koi
            'sertifikat_koi.*.*' => 'nullable|image|max:2048', // Aturan untuk sertifikat koi
        ]);

        // Loop untuk setiap koi yang diinputkan
        foreach ($request->jenis_koi as $index => $jenisKoi) {
            // Simpan data koi ke database
            $koi = Koi::create([
                'auction_id' => $request->auction_id, // Pastikan auction_id sudah dikirim dari form
                'kode_ikan' => $request->kode_ikan[$index], // Tambahkan kode_ikan
                'jenis_koi' => $jenisKoi,
                'ukuran' => $request->ukuran[$index],
                'gender' => $request->gender[$index],
                'open_bid' => $request->open_bid[$index],
                'kelipatan_bid' => $request->kelipatan_bid[$index],
                'buy_it_now' => $request->buy_it_now[$index] ?? null,
            ]);

            // Simpan media koi (foto/video) ke tabel media
            if ($request->hasFile("video_koi.{$index}")) {
                $videoPath = $request->file("video_koi.{$index}")->store('koi_videos', 'public');
                Media::create([
                    'koi_id' => $koi->id,
                    'url_media' => $videoPath,
                    'media_type' => 'video'
                ]);
            }

            if ($request->hasFile("gambar_koi.{$index}")) {
                foreach ($request->file("gambar_koi.{$index}") as $gambarKoi) {
                    $imagePath = $gambarKoi->store('koi_images', 'public');
                    Media::create([
                        'koi_id' => $koi->id,
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
                        'koi_id' => $koi->id,
                        'url_gambar' => $certificatePath
                    ]);
                }
            }
        }

        return redirect()->route('auctions.index')->with('success', 'Data Koi berhasil disimpan!');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $koi = Koi::find($id);

        if ($koi) {
            // Hapus media yang terkait
            $koi->media()->delete();
            // Hapus data koi
            $koi->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Koi not found']);
    }
}
