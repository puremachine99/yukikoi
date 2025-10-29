<?php

namespace Tests\Feature;

use App\Jobs\UpdateAuctionStatus;
use App\Models\Auction;
use App\Models\Koi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UpdateAuctionStatusTest extends TestCase
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

    public function test_job_marks_auction_as_completed_when_deadline_passed(): void
    {
        Broadcast::fake();
        Event::fake();

        $seller = User::factory()->create([
            'role' => 'seller',
            'is_seller' => true,
        ]);

        $auction = Auction::create([
            'title' => 'Closing Auction',
            'description' => 'Ends immediately',
            'jenis' => 'reguler',
            'status' => 'on going',
            'start_time' => now()->subHours(2),
            'end_time' => now()->subMinutes(5),
            'extra_time' => 0,
            'user_id' => $seller->id,
        ]);

        Koi::create([
            'id' => 'KOI-CLOSE',
            'auction_code' => $auction->auction_code,
            'kode_ikan' => 'CL-01',
            'judul' => 'Closing Kohaku',
            'jenis_koi' => 'Kohaku',
            'ukuran' => 28,
            'gender' => 'male',
            'open_bid' => 700000,
            'kelipatan_bid' => 50000,
            'buy_it_now' => null,
            'keterangan' => 'Testing closure',
            'breeder' => 'Koi Breeder',
        ]);

        $job = new UpdateAuctionStatus($auction->auction_code);
        $job->handle();

        $this->assertSame('completed', $auction->fresh()->status);
    }
}
