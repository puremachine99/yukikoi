<?php

namespace Tests\Feature;

use App\Models\Auction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuctionCodeGeneratorTest extends TestCase
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

    public function test_auction_code_sequence_increments_without_collision(): void
    {
        $seller = User::factory()->create([
            'role' => 'seller',
            'is_seller' => true,
        ]);

        $first = Auction::create([
            'title' => 'Morning Auction',
            'description' => 'First catalogue',
            'jenis' => 'reguler',
            'status' => 'ready',
            'start_time' => now(),
            'end_time' => now()->addHours(2),
            'user_id' => $seller->id,
        ]);

        $second = Auction::create([
            'title' => 'Evening Auction',
            'description' => 'Second catalogue',
            'jenis' => 'reguler',
            'status' => 'ready',
            'start_time' => now(),
            'end_time' => now()->addHours(4),
            'user_id' => $seller->id,
        ]);

        $this->assertNotEquals($first->auction_code, $second->auction_code);
        $this->assertSame(substr($first->auction_code, 0, 4), substr($second->auction_code, 0, 4));

        $firstSequence = (int) substr($first->auction_code, -3);
        $secondSequence = (int) substr($second->auction_code, -3);

        $this->assertSame($firstSequence + 1, $secondSequence);
    }
}
