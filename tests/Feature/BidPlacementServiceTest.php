<?php

namespace Tests\Feature;

use App\Events\ExtraTimeAdded;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Koi;
use App\Models\User;
use App\Services\BidPlacementService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class BidPlacementServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);
    }

    public function test_sniping_bid_adds_extra_time_and_broadcasts_event(): void
    {
        Broadcast::fake();
        Event::fake([ExtraTimeAdded::class]);

        $seller = User::factory()->create([
            'role' => 'seller',
            'is_seller' => true,
        ]);

        $buyer = User::factory()->create([
            'role' => 'buyer',
        ]);

        $auction = Auction::create([
            'title' => 'Night Auction',
            'description' => 'Limited edition koi',
            'jenis' => 'reguler',
            'status' => 'on going',
            'start_time' => now()->subHour(),
            'end_time' => now()->subMinutes(2),
            'extra_time' => 0,
            'user_id' => $seller->id,
        ]);

        $koi = Koi::create([
            'id' => 'KOI-SNIPE',
            'auction_code' => $auction->auction_code,
            'kode_ikan' => 'SN-01',
            'judul' => 'Snipe Kohaku',
            'jenis_koi' => 'Kohaku',
            'ukuran' => 35,
            'gender' => 'female',
            'open_bid' => 1000000,
            'kelipatan_bid' => 50000,
            'buy_it_now' => 2000000,
            'keterangan' => 'Fast closing auction',
            'breeder' => 'Premium Breeder',
        ]);

        $service = app(BidPlacementService::class);

        $result = $service->placeBid($buyer, $koi->id, 1050000);

        $auction->refresh();

        $this->assertTrue($result['is_sniping']);
        $this->assertSame(10, $auction->extra_time);
        $this->assertInstanceOf(Bid::class, $result['bid']);
        Event::assertDispatched(ExtraTimeAdded::class);
    }

    public function test_seller_cannot_place_bid_on_own_auction(): void
    {
        $seller = User::factory()->create([
            'role' => 'seller',
            'is_seller' => true,
        ]);

        $auction = Auction::create([
            'title' => 'Seller Auction',
            'description' => 'Internal listing',
            'jenis' => 'reguler',
            'status' => 'on going',
            'start_time' => now()->subHour(),
            'end_time' => now()->addHour(),
            'extra_time' => 0,
            'user_id' => $seller->id,
        ]);

        $koi = Koi::create([
            'id' => 'KOI-SELLER',
            'auction_code' => $auction->auction_code,
            'kode_ikan' => 'SL-01',
            'judul' => 'Seller Kohaku',
            'jenis_koi' => 'Kohaku',
            'ukuran' => 30,
            'gender' => 'male',
            'open_bid' => 800000,
            'kelipatan_bid' => 50000,
            'buy_it_now' => 1500000,
            'keterangan' => 'Should not be able to bid',
            'breeder' => 'Internal',
        ]);

        $service = app(BidPlacementService::class);

        $this->expectException(AuthorizationException::class);

        $service->placeBid($seller, $koi->id, 850000);
    }
}
