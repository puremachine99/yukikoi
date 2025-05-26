<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auction;
use App\Models\User;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index()
    {
        // Ambil semua auction beserta relasi user
        $auctions = Auction::with('user')->paginate(10);

        return view('admin.auctions.index', compact('auctions'));
    }
}
