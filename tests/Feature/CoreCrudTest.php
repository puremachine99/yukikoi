<?php

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Koi;
use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

uses(RefreshDatabase::class);

beforeEach(function () {
    config([
        'filesystems.default' => 's3',
        'filesystems.disks.s3' => [
            'driver' => 's3',
            'key' => 'testing-key',
            'secret' => 'testing-secret',
            'region' => 'us-east-1',
            'bucket' => 'testing-bucket',
            'url' => 'https://object-storage.test/testing-bucket',
            'endpoint' => 'https://object-storage.test',
            'use_path_style_endpoint' => true,
        ],
        'imgproxy.url' => 'https://imgproxy.test',
        'imgproxy.should_sign' => false,
        'imgproxy.source_url_base' => 'https://object-storage.test/testing-bucket',
    ]);
});

it('handles phone-based registration, login, and core auction flow', function () {
    Storage::fake('public');

    // === Seller registration ===
    $registerSeller = $this->post('/register', [
        'name' => 'Seller One',
        'email' => 'seller@example.com',
        'phone_number' => '08225712345',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $registerSeller->assertRedirect(route('home', absolute: false));

    $seller = User::where('phone_number', '08225712345')->firstOrFail();
    assertAuthenticatedAs($seller);

    // Logout then login again using phone number
    $this->post('/logout');
    assertGuest();

    $loginSeller = $this->post('/login', [
        'phone_number' => '08225712345',
        'password' => 'password',
    ]);

    $loginSeller->assertRedirect(route('home', absolute: false));
    assertAuthenticatedAs($seller->fresh());

    // Update seller profile with required fields
    $updateSeller = $this->patch(route('profile.update'), [
        'name' => 'Seller One Updated',
        'email' => 'seller@example.com',
        'farm_name' => 'Yuki Farm',
        'address' => 'Jl. Sakura No.1',
        'city' => 'Bandung',
        'phone_number' => '08225712345',
        'nik' => '3201011990010101',
        'bio' => 'Professional koi breeder',
        'whatsapp' => '08225712345',
        'instagram' => '@yukikoi',
        'youtube' => 'yukikoi-channel',
        'is_seller' => true,
    ]);

    $updateSeller->assertRedirect(route('profile.edit'));

    $seller->refresh();
    expect($seller->farm_name)->toBe('Yuki Farm');
    expect($seller->bio)->toBe('Professional koi breeder');

    // Create auction
    $auction = Auction::create([
        'title' => 'Autumn Harvest Auction',
        'description' => 'Premium koi lot',
        'jenis' => 'reguler',
        'status' => 'draft',
        'start_time' => now()->addHour(),
        'end_time' => now()->addDays(2),
        'user_id' => $seller->id,
    ]);

    assertDatabaseHas('auctions', [
        'auction_code' => $auction->auction_code,
        'title' => 'Autumn Harvest Auction',
    ]);

    $auction->update([
        'title' => 'Autumn Harvest Auction Updated',
        'status' => 'ready',
    ]);

    expect($auction->fresh()->status)->toBe('ready');

    // Add koi to auction
    $koi = Koi::create([
        'id' => (string) Str::uuid(),
        'auction_code' => $auction->auction_code,
        'kode_ikan' => 'KOI-001',
        'judul' => 'Gin Rin Kohaku',
        'jenis_koi' => 'kohaku',
        'ukuran' => 35,
        'gender' => 'Male',
        'open_bid' => 100_000,
        'kelipatan_bid' => 5_000,
        'buy_it_now' => 400_000,
        'keterangan' => 'High quality koi',
        'breeder' => 'Yuki Farm',
    ]);

    assertDatabaseHas('kois', [
        'id' => $koi->id,
        'judul' => 'Gin Rin Kohaku',
    ]);

    $koi->update([
        'judul' => 'Gin Rin Kohaku Updated',
        'buy_it_now' => 420_000,
    ]);

    expect($koi->fresh()->buy_it_now)->toBe(420_000.0);

    // Attach media via Imgproxy-aware helper
    $media = Media::create([
        'koi_id' => $koi->id,
        'url_media' => 'photos/sample-koi.jpg',
        'media_type' => 'photo',
    ]);

    expect($media->proxy_url)->toContain('imgproxy');

    // Start the auction
    $auction->update([
        'status' => 'on going',
        'start_time' => now()->subMinutes(5),
    ]);

    expect($auction->fresh()->status)->toBe('on going');

    // === Buyer registration & bidding ===
    $this->post('/logout');
    assertGuest();

    $registerBuyer = $this->post('/register', [
        'name' => 'Buyer One',
        'email' => 'buyer@example.com',
        'phone_number' => '08225754321',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $registerBuyer->assertRedirect(route('home', absolute: false));

    $buyer = User::where('phone_number', '08225754321')->firstOrFail();
    assertAuthenticatedAs($buyer);

    $bid = Bid::create([
        'koi_id' => $koi->id,
        'user_id' => $buyer->id,
        'amount' => 120_000,
        'is_win' => false,
        'is_bin' => false,
        'is_sniping' => false,
    ]);

    assertDatabaseHas('bids', [
        'id' => $bid->id,
        'user_id' => $buyer->id,
    ]);

    // Promote bid to winner
    $bid->update(['is_win' => true]);
    expect($bid->fresh()->is_win)->toBeTrue();

    // === Cleanup ===
    $bidId = $bid->id;
    $mediaId = $media->id;
    $koiId = $koi->id;
    $auctionCode = $auction->auction_code;
    $sellerId = $seller->id;
    $buyerId = $buyer->id;

    $bid->delete();
    $media->delete();
    $koi->delete();
    $auction->delete();

    $this->post('/logout');
    $seller->delete();
    $buyer->delete();

    assertDatabaseMissing('bids', ['id' => $bidId]);
    assertDatabaseMissing('media', ['id' => $mediaId]);
    assertDatabaseMissing('kois', ['id' => $koiId]);
    assertDatabaseMissing('auctions', ['auction_code' => $auctionCode]);
    assertDatabaseMissing('users', ['id' => $sellerId]);
    assertDatabaseMissing('users', ['id' => $buyerId]);
});
