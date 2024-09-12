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

// Rute Auction
Route::middleware(['auth'])->group(function () {
    Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');
    Route::get('/auctions/create', [AuctionController::class, 'create'])->name('auctions.create');
    Route::post('/auctions', [AuctionController::class, 'store'])->name('auctions.store');
    Route::get('/auctions/{auction_code}/edit', [AuctionController::class, 'edit'])->name('auctions.edit');
    Route::put('/auctions/{auction_code}', [AuctionController::class, 'update'])->name('auctions.update');
    Route::delete('/auctions/{auction_code}', [AuctionController::class, 'destroy'])->name('auctions.destroy');
    Route::get('/auctions/{auction_code}', [AuctionController::class, 'show'])->name('auctions.show');
    Route::post('/auctions/{auction_code}/start', [AuctionController::class, 'startAuction'])->name('auctions.start');
});

Route::get('/auctions/ongoing', [AuctionController::class, 'onGoingAuctions'])->name('auctions.ongoing');
Route::get('/fetch-auctions', [AuctionController::class, 'fetchAuctions'])->name('fetch.auctions');
// Akhir Rute Auction

// Rute Koi
Route::middleware(['auth'])->group(function () {
    Route::get('/koi/{auction_code}', [KoiController::class, 'index'])->name('koi.index');
    Route::get('/koi/create/{auction_code}', [KoiController::class, 'create'])->name('koi.create');
    Route::post('/koi', [KoiController::class, 'store'])->name('koi.store');
    Route::get('/koi/{auction_code}/edit', [KoiController::class, 'edit'])->name('koi.edit');
    Route::put('/koi/{auction_code}', [KoiController::class, 'update'])->name('koi.update');
    Route::delete('/koi/{auction_code}', [KoiController::class, 'destroy'])->name('koi.destroy');
});

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
