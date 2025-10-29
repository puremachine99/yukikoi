<?php

namespace Tests\Feature;

use App\Models\Auction;
use App\Models\Cart;
use App\Models\Koi;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Tests\TestCase;
use Xendit\Invoice\CreateInvoiceRequest;

class BidPaymentFlowTest extends TestCase
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

    protected function setUp(): void
    {
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=:memory:');

        parent::setUp();
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_successful_buy_now_checkout_and_xendit_payment_webhook_flow(): void
    {
        Broadcast::fake();
        Notification::fake();

        // Fake InvoiceApi so we never hit the real Xendit sandbox during tests.
        $invoiceUrl = 'https://sandbox.xendit.co/payments/inv_test_123';
        Mockery::mock('overload:Xendit\Invoice\InvoiceApi')
            ->shouldReceive('createInvoice')
            ->once()
            ->with(Mockery::type(CreateInvoiceRequest::class))
            ->andReturn([
                'id' => 'inv_test_123',
                'invoice_url' => $invoiceUrl,
            ]);

        $seller = User::factory()->create([
            'role' => 'seller',
            'is_seller' => true,
            'farm_name' => 'KoiFarm',
            'city' => 'Bandung',
            'phone_number' => '081234567890',
        ]);

        $buyer = User::factory()->create([
            'role' => 'buyer',
            'email' => 'buyer@example.com',
            'phone_number' => '089876543210',
        ]);

        $auction = Auction::create([
            'title' => 'Super Koi Auction',
            'description' => 'High quality koi for collectors',
            'jenis' => 'reguler',
            'status' => 'on going',
            'start_time' => now()->subHours(1),
            'end_time' => now()->addHours(1),
            'banner' => null,
            'user_id' => $seller->id,
        ]);

        $koi = Koi::create([
            'id' => 'KOI-001',
            'auction_code' => $auction->auction_code,
            'kode_ikan' => 'KF-001',
            'judul' => 'Kohaku Premium',
            'jenis_koi' => 'Kohaku',
            'ukuran' => 40,
            'gender' => 'female',
            'open_bid' => 1000000,
            'kelipatan_bid' => 100000,
            'buy_it_now' => 1500000,
            'keterangan' => 'Healthy koi fish',
            'breeder' => 'Top Breeder',
        ]);

        $this->actingAs($buyer);

        $binResponse = $this->postJson(route('bids.bin'), [
            'koi_id' => $koi->id,
        ]);

        $binResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $cart = Cart::first();
        $this->assertNotNull($cart);
        $this->assertEquals($buyer->id, $cart->user_id);
        $this->assertEquals($koi->id, $cart->koi_id);

        $checkoutView = $this->post(route('cart.checkout'), [
            'cart_ids' => json_encode([$cart->id]),
        ]);

        $checkoutView->assertStatus(200);
        $checkoutView->assertViewIs('cart.checkout');

        $confirmResponse = $this->post(route('cart.confirmCheckout'), [
            'cart_ids' => [$cart->id],
            'shipping_fees' => [
                'KoiFarm' => 20000,
            ],
            'rekber_fee' => 5000,
            'addresses' => [
                'KoiFarm' => [
                    'address_id' => json_encode([
                        'type' => 'buyer',
                        'full_address' => 'Jl. Pembeli No. 123',
                        'nama' => $buyer->name,
                        'phone' => $buyer->phone_number,
                    ]),
                ],
            ],
        ]);

        $confirmResponse->assertRedirect($invoiceUrl);

        $this->assertDatabaseCount('carts', 0);

        $transaction = Transaction::first();
        $this->assertNotNull($transaction);
        $this->assertEquals($buyer->id, $transaction->user_id);
        $this->assertEquals('pending', $transaction->status);
        $this->assertEquals($invoiceUrl, $transaction->checkout_link);

        $transactionItem = TransactionItem::first();
        $this->assertNotNull($transactionItem);
        $this->assertEquals($transaction->id, $transactionItem->transaction_id);
        $this->assertEquals($koi->id, $transactionItem->koi_id);
        $this->assertEquals($seller->id, $transactionItem->seller_id);
        $this->assertEquals($buyer->id, $transactionItem->buyer_id);
        $this->assertEquals('Jl. Pembeli No. 123', $transactionItem->shipping_address);

        $webhookResponse = $this->postJson('/webhook/xendit', [
            'status' => 'PAID',
            'external_id' => $transaction->external_id,
        ]);

        $webhookResponse->assertStatus(200);

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'status' => 'completed',
        ]);
    }
}
