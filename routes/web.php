<?php

use Illuminate\Support\Facades\Route;
use App\Models\Koi;

use App\Http\Controllers\{
    BidController,
    KoiController,
    ChatController,
    HomeController,
    UserAddressController,
    FollowController,
    AuctionController,
    ProfileController,
    TransactionController,
    CartController,
    LiveAuctionController,
    UserActivityController,
    XenditWebhookController,
    EventController,
    WishlistController,
    ComplaintController,
};
// use App\Http\Controllers\Admin\{
//     DashboardController
// };
//test whatsapp
use App\Http\Controllers\WhatsAppController;

Route::get('/send-wa', function () {
    return view('send-wa');
});

Route::post('/send-wa', [WhatsAppController::class, 'sendTestMessage']);
// routes/web.php
Route::post('/send-otp', [WhatsAppController::class, 'sendOtp']);
Route::post('/verify-otp', [WhatsAppController::class, 'verifyOtp']);


// Group routes for event module
Route::middleware('auth')->group(function () {
    // create koi list per event
    Route::get('/events/{id}/koi/create', [EventController::class, 'addKoi'])->name('events.addKoi');
    Route::post('/events/{id}/koi', [EventController::class, 'storeKoi'])->name('events.storeKoi');
    Route::get('/events/{event}/koi', [KoiController::class, 'list'])->name('events.koi.list');

    // List all events or auctions created by the user
    Route::get('/events/list', [EventController::class, 'list'])->name('events.list');

    // Create a new event
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');

    // Edit and update an event
    Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');

    // Delete an event
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');

    // Form for user participation
    Route::get('/events/{id}/participate', [EventController::class, 'participate'])->name('events.participate');
    Route::post('/events/{id}/participate', [EventController::class, 'submitParticipation'])->name('events.submitParticipation');
});

// Routes accessible without authentication
Route::get('/events', [EventController::class, 'index'])->name('events.index'); // List all events
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show'); // Show event details
Route::get('/events/live', [EventController::class, 'live'])->name('events.live'); // Show live events

// Route::get('/admin', function () {
//     return view('yukiadmin.index');
// })->name('yukiadmin');

// Home Route - Terbuka untuk semua
Route::get('/', [HomeController::class, 'index'])->name('home');

// Live Lelang Route 
Route::get('/live-auction', [LiveAuctionController::class, 'index'])->name('live.index');
Route::get('/live-auction/search', [LiveAuctionController::class, 'search'])->name('live.search');

// Dashboard Route (terverifikasi yang login)
Route::get('/dashboard/{koi?}', function (Koi $koi = null) {
    return view('dashboard', ['koi' => $koi]);
})->middleware(['auth', 'verified'])->name('dashboard');


// Pricing 
Route::get('/pricing/', function () {
    return view('pricing.index');
})->name('pricing.index');

// Follow Routes 
Route::post('/follow/{userId}', [FollowController::class, 'follow'])->name('follow');
Route::delete('/unfollow/{user}', [FollowController::class, 'unfollow'])->name('unfollow');

// Route Cart
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout/confirm', [CartController::class, 'confirmCheckout'])->name('cart.confirmCheckout');
    Route::get('/checkout/failed', [CartController::class, 'checkoutFailed'])->name('cart.failed');
});

// Route Transaction
Route::middleware(['auth'])->group(function () {
    // Route for transaction list
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    // Route invoice
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    // payment ke xendit
    Route::post('/transactions/{transactionId}/payment', [TransactionController::class, 'payment'])->name('transactions.payment');
    // routes/web.php
    Route::post('/transactions/{transaction}/pay', [TransactionController::class, 'pay'])->name('transactions.pay');

    //Buyer
    Route::post('/transactions/update-status', [TransactionController::class, 'updateStatus'])
        ->name('transactions.updateStatus')
        ->middleware('throttle:10,1'); // limit (10 kali per menit)
    Route::post('/transactions/retur', [TransactionController::class, 'retur'])->name('transactions.retur');
    Route::post('/transactions/rate', [TransactionController::class, 'storeRating'])->name('transactions.rate');

    Route::post('/complaint/store', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::post('/complaint/{id}/update-status', [ComplaintController::class, 'updateStatus'])->name('complaints.update');

    //Seller
    Route::get('/orders', [TransactionController::class, 'sellerOrders'])->name('orders.index');
    Route::post('/orders/update-status', [TransactionController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/upload/cancel-video', function (Illuminate\Http\Request $request) {
        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('videos', 'public');
            return response()->json([
                'success' => true,
                'path' => '/storage/' . $path,
            ]);
        }
        return response()->json(['success' => false], 400);
    })->name('upload.cancel.video');

});


// Auction Routes
Route::middleware('auth')->group(function () {
    Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');
    Route::get('/auctions/create', [AuctionController::class, 'create'])->name('auctions.create');
    Route::post('/auctions', [AuctionController::class, 'store'])->name('auctions.store');
    Route::get('/auctions/{auction_code}/edit', [AuctionController::class, 'edit'])->name('auctions.edit');
    Route::put('/auctions/{auction_code}', [AuctionController::class, 'update'])->name('auctions.update');
    Route::delete('/auctions/{auction_code}', [AuctionController::class, 'destroy'])->name('auctions.destroy');
    Route::post('/auctions/{auction_code}/start', [AuctionController::class, 'startAuction'])->name('auctions.start');
    Route::get('/fetch-auctions', [AuctionController::class, 'fetchAuctions'])->name('fetch.auctions');
    Route::get('/my-auctions', [AuctionController::class, 'userAuctions'])->name('auctions.user');
    Route::get('/auctions/{auction_code}/recap', [AuctionController::class, 'recap'])->name('auctions.recap');
});

// Lelang yang bisa dilihat semua user (guest dapat akses)
Route::get('/auctions/{auction_code}', [AuctionController::class, 'show'])->name('auctions.show');
Route::get('/auctions/ongoing', [AuctionController::class, 'onGoingAuctions'])->name('auctions.ongoing');
Route::post('/auctions/status', [AuctionController::class, 'checkStatus'])->name('auctions.checkStatus');

// Koi Routes - Seller, Priority Seller, dan Admin
Route::middleware(['auth'])->group(function () {
    Route::get('/koi/{auction_code}', [KoiController::class, 'index'])->name('koi.index'); // List Koi
    Route::get('/koi/create/{auction_code}', [KoiController::class, 'create'])->name('koi.create'); // Create Koi
    Route::get('/koi/{auction_code}/{id}/edit', [KoiController::class, 'edit'])->name('koi.edit'); // Edit Koi
    Route::post('/koi', [KoiController::class, 'store'])->name('koi.store'); // Store Koi
    Route::put('/koi/{id}', [KoiController::class, 'update'])->name('koi.update'); // Update Koi
    Route::delete('/koi/{auction_code}/{id}', [KoiController::class, 'destroy'])->name('koi.destroy'); // Delete Koi
    Route::delete('/media/{id}', [KoiController::class, 'deleteMedia'])->name('media.delete');
    Route::delete('/certificates/{id}', [KoiController::class, 'deleteCertificate'])->name('certificates.delete');
});


// Middleware untuk meningkatkan view count
Route::middleware([\App\Http\Middleware\CountViews::class])->group(function () {
    Route::get('/koi/{id}/bid', [KoiController::class, 'show'])->name('koi.show'); // Show Koi
});


// Route::get('/koi/{id}/bid', [KoiController::class, 'show'])->name('koi.show');

// Bid Routes - Bidder, Seller, Priority Seller, Admin
Route::middleware(['auth'])->group(function () {
    Route::get('/user-bids', [BidController::class, 'userBids'])->name('bids.user'); // monitoring bid user
    Route::post('/bids/place', [BidController::class, 'store'])->name('bids.store');
    Route::post('/bids/buyNow', [BidController::class, 'buyNow'])->name('bids.buyNow');
    Route::post('/bids/check', [BidController::class, 'checkBid'])->name('bids.check');
    Route::post('/bin/confirm', [BidController::class, 'confirmBIN'])->name('bids.bin');
    Route::post('/pin/confirm', [BidController::class, 'confirmPin'])->name('pin.confirm');
});
Route::get('/bids/{auction}', [BidController::class, 'index'])->name('bids.index'); // Semua user bisa melihat bid

// Chat Routes - Bidder, Seller, Priority Seller, Admin
Route::middleware(['auth'])->group(function () {
    Route::post('/chat/store', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/history/{koiId}', [ChatController::class, 'getHistory'])->name('chat.history');
});

// Profile Routes - Semua Pengguna Terdaftar
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/become-seller', [ProfileController::class, 'becomeSeller'])->name('profile.becomeSeller');
});

// Route untuk alamat
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/addresses', [UserAddressController::class, 'index'])->name('profile.addresses.index');
    Route::post('/profile/addresses', [UserAddressController::class, 'store'])->name('profile.addresses.store');
    Route::put('/profile/addresses/{address}', [UserAddressController::class, 'update'])->name('profile.addresses.update');
    Route::delete('/profile/addresses/{address}', [UserAddressController::class, 'destroy'])->name('profile.addresses.destroy');

    // Route tambahan untuk set default
    Route::post('/profile/addresses/{address}/set-default', [UserAddressController::class, 'setDefault'])->name('profile.addresses.setDefault');
});

// route count view dan like / dislike
Route::middleware('auth')->group(function () {
    Route::post('/koi/{koiId}/like', [UserActivityController::class, 'toggleLike']);
    Route::post('/koi/{koiId}/view', [UserActivityController::class, 'view']);
});

Route::middleware('auth')->group(function () {
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
});

Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');


// Route::middleware(['auth', '\App\Http\Middleware\AdminMiddleware::class'])->prefix('admin')->name('admin.')->group(function () {
//     // Dashboard
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//     // Users
//     Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
//     Route::get('/users/bnr', [\App\Http\Controllers\Admin\UserController::class, 'create'])->name('users.bnr');
//     Route::post('/users/bnr', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('users.store');
//     Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

//     // Tambahkan route lain sesuai kebutuhan, misal edit, update, destroy

//     // Auctions (contoh, sesuaikan dengan controller dan kebutuhan)
//     Route::get('/auctions', [\App\Http\Controllers\Admin\AuctionController::class, 'index'])->name('auctions.index');
//     // Tambahkan route lain sesuai kebutuhan

//     // Event (contoh, sesuaikan dengan controller dan kebutuhan)
//     Route::get('/events', [\App\Http\Controllers\Admin\EventController::class, 'index'])->name('events.index');
//     // Tambahkan route lain sesuai kebutuhan

//     // Ads (contoh, sesuaikan dengan controller dan kebutuhan)
//     Route::get('/ads', [\App\Http\Controllers\Admin\AdsController::class, 'index'])->name('ads.index');
//     // Tambahkan route lain sesuai kebutuhan
// });


// Xendit Webhook
Route::post('/webhook/xendit', [XenditWebhookController::class, 'handle']);

Route::get('/version', function () {
    return [
        'laravel_version' => app()->version(),
        'php_version' => phpversion(),
        'app_version' => config('app.version', '1.0.0'), // Tambahkan di config/app.php
        'environment' => config('app.env'),
    ];
});

// Auth Routes
require __DIR__ . '/auth.php';


// ... existing routes ...
