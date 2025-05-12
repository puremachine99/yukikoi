<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Koi;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Certificate;
use App\Models\Media;
use App\Models\Transaction;
use App\Models\Event;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin
     */
    public function index()
    {
        // Statistik dasar untuk dashboard
        $stats = [
            'total_users' => User::count(),
            'total_kois' => Koi::count(),
            'total_auctions' => Auction::count(),
            'total_bids' => Bid::count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_auctions' => Auction::with('koi')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Mengelola pengguna
     */
    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan detail pengguna
     */
    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Mengelola koi
     */
    public function kois()
    {
        $kois = Koi::with('certificate')->latest()->paginate(15);
        return view('admin.kois.index', compact('kois'));
    }

    /**
     * Menampilkan detail koi
     */
    public function showKoi($id)
    {
        $koi = Koi::with(['certificate', 'media'])->findOrFail($id);
        return view('admin.kois.show', compact('koi'));
    }

    /**
     * Mengelola lelang
     */
    public function auctions()
    {
        $auctions = Auction::with(['koi', 'user'])->latest()->paginate(15);
        return view('admin.auctions.index', compact('auctions'));
    }

    /**
     * Menampilkan detail lelang
     */
    public function showAuction($id)
    {
        $auction = Auction::with(['koi', 'user', 'bids.user'])->findOrFail($id);
        return view('admin.auctions.show', compact('auction'));
    }

    /**
     * Mengelola sertifikat
     */
    public function certificates()
    {
        $certificates = Certificate::with('koi')->latest()->paginate(15);
        return view('admin.certificates.index', compact('certificates'));
    }

    /**
     * Mengelola media
     */
    public function media()
    {
        $media = Media::latest()->paginate(15);
        return view('admin.media.index', compact('media'));
    }

    /**
     * Mengelola transaksi
     */
    public function transactions()
    {
        $transactions = Transaction::with('user')->latest()->paginate(15);
        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Menampilkan detail transaksi
     */
    public function showTransaction($id)
    {
        $transaction = Transaction::with(['user', 'items'])->findOrFail($id);
        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * Mengelola event
     */
    public function events()
    {
        $events = Event::latest()->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Menampilkan detail event
     */
    public function showEvent($id)
    {
        $event = Event::with('kois')->findOrFail($id);
        return view('admin.events.show', compact('event'));
    }

    /**
     * Mengelola keluhan
     */
    public function complaints()
    {
        $complaints = Complaint::with(['user'])->latest()->paginate(15);
        return view('admin.complaints.index', compact('complaints'));
    }

    /**
     * Menampilkan detail keluhan
     */
    public function showComplaint($id)
    {
        $complaint = Complaint::with(['user', 'transactionItem'])->findOrFail($id);
        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Menampilkan laporan dan statistik
     */
    public function reports()
    {
        // Data untuk laporan
        $monthlyUsers = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();
            
        $monthlyAuctions = Auction::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();
            
        $topSellers = User::withCount('auctions')
            ->orderBy('auctions_count', 'desc')
            ->take(10)
            ->get();

        return view('admin.reports', compact('monthlyUsers', 'monthlyAuctions', 'topSellers'));
    }

    /**
     * Menampilkan pengaturan sistem
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Menyimpan pengaturan sistem
     */
    public function saveSettings(Request $request)
    {
        // Validasi dan simpan pengaturan
        $request->validate([
            'site_name' => 'required|string|max:255',
            'maintenance_mode' => 'boolean',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        // Simpan pengaturan ke database atau file konfigurasi
        // ...

        return redirect()->route('admin.settings')->with('success', 'Pengaturan berhasil disimpan');
    }
}
