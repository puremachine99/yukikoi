<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;

class DashboardController extends Controller
{
    /**
     * Show the dashboard page with ongoing auctions.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua lelang yang sedang berlangsung atau sesuai filter lainnya
        $auctions = Auction::all();

        // Kirimkan data ke view
        return view('/', compact('auctions'));
    }
}
