<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BidController;
use App\Http\Controllers\KoiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\ProfileController;



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// Rute umum
Route::get('/', [HomeController::class, 'index'])->name('home');
// Rute untuk lelang (Auction)
Route::middleware('auth')->resource('auctions', AuctionController::class)->except(['show']);
Route::get('/auctions/ongoing', [AuctionController::class, 'onGoingAuctions'])->name('auctions.ongoing');
Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');
Route::middleware('auth')->post('/auctions/{auction}/start', [AuctionController::class, 'startAuction'])->name('auctions.start');

// Rute lelang Koi 
Route::middleware('auth')->resource('koi', KoiController::class)->except(['show']);
Route::middleware('auth')->get('/koi/create', [KoiController::class, 'create'])->name('koi.create');
Route::get('/koi/{auction_id}', [KoiController::class, 'index'])->name('koi.index');
Route::delete('/koi/{id}', [KoiController::class, 'destroy'])->name('koi.destroy');

// Rute untuk bid (umum dan khusus login)
Route::middleware('auth')->resource('bid', BidController::class)->except(['show']);
Route::get('/bids/{auction}', [BidController::class, 'index'])->name('bids.index'); // Bisa diakses tanpa login
Route::middleware('auth')->post('/bids/{auction}/{koi}', [BidController::class, 'store'])->name('bids.store'); // Hanya user yang login bisa bid

// Rute Media

// Rute profile (umum dan login)
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/become-seller', [ProfileController::class, 'becomeSeller'])->name('profile.becomeSeller');
});

// Resource routes for other controllers
Route::resource('users', UserController::class);

// Auth routes
require __DIR__ . '/auth.php';
