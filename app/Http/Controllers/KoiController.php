<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Koi;
use App\Models\Event;
use App\Models\Media;
use App\Models\Auction;
use App\Models\Wishlist;
use App\Models\MarkedKoi;
use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Services\KoiEnricher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KoiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request, $auction_code, KoiEnricher $enricher)
    {
        $userId = Auth::id();

        $auction = Auction::with('user')->where('auction_code', $auction_code)->firstOrFail();

        // Ambil semua koi yang ada di lelang ini, dengan struktur sama seperti di LiveController
        $kois = $enricher->getLiveAuctionKois($request, $userId)
            ->filter(fn($koi) => $koi->auction_code === $auction_code)
            ->values(); // reset index karena filter

        // Ambil data wishlist user
        $wishlist = Wishlist::where('user_id', $userId)->pluck('koi_id')->toArray();

        return view('koi.index', compact('kois', 'auction', 'auction_code', 'wishlist'));
    }

    public function list(Request $request, $id)
    {
        // Cek apakah ini event atau lelang reguler
        $event = Event::find($id);

        if ($event) {
            // Ambil koi berdasarkan event
            $koi = Koi::where('event_id', $id)->paginate(10);
            return view('koi.index', compact('koi', 'event'));
        } else {
            // Jika bukan event, asumsikan ini lelang reguler berdasarkan auction_code
            $koi = Koi::where('auction_code', $id)->paginate(10);
            return view('koi.index', compact('koi'));
        }
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
        // dd($request->all());
        Log::info('Request Data:', $request->all());
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
    public function show($id)
    {
        // Ambil Koi dengan eager loading yang lebih lengkap dan filter khusus pada auction, bids, dan chats
        $koi = Koi::with([
            'auction' => function ($query) {
                $query->with('user:id,name,phone_number,city,farm_name,address'); // Relasi Auction dan User
            },
            'bids' => function ($query) {
                $query->with('user:id,name,phone_number,profile_photo') // Relasi Bids dan User
                    ->orderBy('created_at', 'asc'); // Urutkan bids
            },
            'chats' => function ($query) {
                $query->with('user:id,name,profile_photo') // Relasi Chats dan User
                    ->orderBy('created_at', 'asc'); // Urutkan chats
            },
            'media',         // Media terkait koi
            'certificates',  // Sertifikat koi
        ])
            ->findOrFail($id); // Dapatkan koi yang sesuai

        // Ambil waktu saat ini
        $currentDate = \Carbon\Carbon::now();

        // Hitung end_time yang sudah ditambahkan dengan extra_time
        $adjustedEndTime = \Carbon\Carbon::parse($koi->auction->end_time)
            ->addMinutes($koi->auction->extra_time);

        // Cek apakah lelang sedang berlangsung
        $isAuctionOngoing = $adjustedEndTime > $currentDate && $koi->auction->start_time <= $currentDate;

        // Cek apakah lelang berstatus ready tetapi belum dimulai
        $isAuctionReady = $koi->auction->status === 'ready' && $koi->auction->start_time > $currentDate;

        // Cek apakah sudah ada yang melakukan BIN
        $isBIN = $koi->bids->where('is_bin', true)->isNotEmpty();

        // Ambil bid terakhir untuk menentukan pemenang (jika ada)
        $winner = $isBIN ? $koi->bids->where('is_bin', true)->first() : $koi->bids->first();

        // Gabungkan bids dan chats lalu urutkan berdasarkan created_at
        $history = $koi->bids->concat($koi->chats)->sortBy('created_at');

        // Ambil koi lain di lelang yang sama berdasarkan auction_code
        $koisInSameAuction = Koi::where('auction_code', $koi->auction_code)
            ->where('id', '!=', $koi->id) // Kecualikan koi ini
            ->with([
                'media' => function ($query) {
                    $query->where('media_type', 'photo'); // Ambil hanya media yang berupa foto
                }
            ])
            ->get();

        // Ambil ikan sejenis berdasarkan category
        $koisSameCategory = Koi::where('jenis_koi', $koi->jenis_koi)
            ->where('id', '!=', $koi->id) // Kecualikan koi ini
            ->whereHas('auction', function ($query) {
                $query->where('status', 'on going'); // Pastikan lelang berstatus on going
            })
            ->with([
                'media' => function ($query) {
                    $query->where('media_type', 'photo'); // Ambil hanya media yang berupa foto
                }
            ])
            ->get();

        // Cek apakah user yang login adalah seller dari koi ini
        $isSeller = Auth::id() == $koi->auction->user_id;

        return view('koi.show', compact('koi', 'koisInSameAuction', 'koisSameCategory', 'isAuctionOngoing', 'isAuctionReady', 'winner', 'history', 'isBIN', 'isSeller'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($auction_code, $id)
    {
        $koi = Koi::where('auction_code', $auction_code)->where('id', $id)->firstOrFail();
        $media = Media::where('koi_id', $id)->get();
        $certificates = Certificate::where('koi_id', $id)->get();

        return view('koi.edit', compact('koi', 'auction_code', 'media', 'certificates'));
    }

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
            'media.*' => 'nullable|file|mimes:jpeg,png,mp4,mov|max:10000',
            'certificates.*' => 'nullable|image|max:2048',
        ]);

        $koi = Koi::findOrFail($id);
        $koi->update($request->only([
            'judul',
            'jenis_koi',
            'ukuran',
            'gender',
            'open_bid',
            'kelipatan_bid',
            'buy_it_now',
            'keterangan',
            'breeder',
        ]));

        // Update Media
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $mediaFile) {
                $mediaPath = $mediaFile->store('koi_media', 'public');
                Media::create([
                    'koi_id' => $id,
                    'url_media' => $mediaPath,
                    'media_type' => $mediaFile->getMimeType() === 'video/mp4' ? 'video' : 'photo',
                ]);
            }
        }

        // Update Certificates
        if ($request->hasFile('certificates')) {
            foreach ($request->file('certificates') as $certificateFile) {
                $certificatePath = $certificateFile->store('koi_certificates', 'public');
                Certificate::create([
                    'koi_id' => $id,
                    'url_gambar' => $certificatePath,
                ]);
            }
        }

        return redirect()->route('koi.index', ['auction_code' => $koi->auction_code])
            ->with('success', 'Koi berhasil diupdate.');
    }

    // Hapus Media
    public function deleteMedia($id)
    {
        $media = Media::find($id);

        if (!$media) {
            return response()->json(['success' => false, 'message' => 'Media tidak ditemukan.'], 404);
        }

        // Hapus file dari storage
        Storage::disk('public')->delete($media->url_media);

        // Hapus record dari database
        $media->delete();

        return response()->json(['success' => true, 'message' => 'Media berhasil dihapus.']);
    }

    // Hapus Sertifikat
    public function deleteCertificate($id)
    {
        $certificate = Certificate::find($id);

        if (!$certificate) {
            return response()->json(['success' => false, 'message' => 'Sertifikat tidak ditemukan.'], 404);
        }

        // Hapus file dari storage
        Storage::disk('public')->delete($certificate->url_gambar);

        // Hapus record dari database
        $certificate->delete();

        return response()->json(['success' => true, 'message' => 'Sertifikat berhasil dihapus.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($auction_code, $id)
    {
        $koi = Koi::where('auction_code', $auction_code)->where('id', $id)->firstOrFail();

        $koi->delete();

        return response()->json(['success' => true, 'message' => 'Koi berhasil dihapus.']);
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
