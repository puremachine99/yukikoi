<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchievementSeeder extends Seeder
{
    public function run()
    {
        $achievements = [
            // Penghasilan / Omzet
            ['condition' => 'seller_rookie_income', 'name' => 'Seller Rookie', 'badge_color' => '#422006', 'icon' => 'fa-star', 'description' => 'Penghasilan Rp20 juta.'],
            ['condition' => 'seller_pro_income', 'name' => 'Seller Pro', 'badge_color' => '#94a3b8', 'icon' => 'fa-trophy', 'description' => 'Penghasilan Rp100 juta.'],
            ['condition' => 'seller_veteran_income', 'name' => 'Seller Veteran', 'badge_color' => '#f59e0b', 'icon' => 'fa-crown', 'description' => 'Penghasilan Rp500 juta+.'],

            // Pengeluaran
            ['condition' => 'small_spender', 'name' => 'Small Spender', 'badge_color' => '#422006', 'icon' => 'fa-wallet', 'description' => 'Pengeluaran Rp10 juta.'],
            ['condition' => 'big_spender', 'name' => 'Big Spender', 'badge_color' => '#94a3b8', 'icon' => 'fa-money-bill', 'description' => 'Pengeluaran Rp50 juta.'],
            ['condition' => 'elite_spender', 'name' => 'Elite Spender', 'badge_color' => '#f59e0b', 'icon' => 'fa-coins', 'description' => 'Pengeluaran Rp100 juta+.'],

            // Jumlah Koi Dibeli
            ['condition' => 'collector_rookie', 'name' => 'Collector Rookie', 'badge_color' => '#422006', 'icon' => 'fa-fish', 'description' => 'Membeli 10 koi.'],
            ['condition' => 'collector_pro', 'name' => 'Collector Pro', 'badge_color' => '#94a3b8', 'icon' => 'fa-box', 'description' => 'Membeli 50 koi.'],
            ['condition' => 'collector_master', 'name' => 'Collector Master', 'badge_color' => '#f59e0b', 'icon' => 'fa-treasure-chest', 'description' => 'Membeli 100 koi+.'],

            // Jumlah Koi Terjual
            ['condition' => 'seller_rookie_sold', 'name' => 'Seller Rookie', 'badge_color' => '#422006', 'icon' => 'fa-handshake', 'description' => 'Menjual 10 koi.'],
            ['condition' => 'seller_pro_sold', 'name' => 'Seller Pro', 'badge_color' => '#94a3b8', 'icon' => 'fa-dolly', 'description' => 'Menjual 50 koi.'],
            ['condition' => 'seller_master_sold', 'name' => 'Seller Master', 'badge_color' => '#f59e0b', 'icon' => 'fa-store', 'description' => 'Menjual 100 koi+.'],

            // Menang dengan Sniping
            ['condition' => 'sniper_rookie', 'name' => 'Sniper Rookie', 'badge_color' => '#422006', 'icon' => 'fa-crosshairs', 'description' => 'Menang di menit terakhir pada 10 lelang.'],
            ['condition' => 'sniper_pro', 'name' => 'Sniper Pro', 'badge_color' => '#94a3b8', 'icon' => 'fa-bullseye', 'description' => 'Menang di menit terakhir pada 50 lelang.'],
            ['condition' => 'sniper_master', 'name' => 'Sniper Master', 'badge_color' => '#f59e0b', 'icon' => 'fa-target', 'description' => 'Menang di menit terakhir pada 100 lelang+.'],

            // Jumlah Buy It Now
            ['condition' => 'bin_rookie', 'name' => 'BIN Rookie', 'badge_color' => '#422006', 'icon' => 'fa-cart-shopping', 'description' => 'Menang dengan BIN sebanyak 10 kali.'],
            ['condition' => 'bin_pro', 'name' => 'BIN Pro', 'badge_color' => '#94a3b8', 'icon' => 'fa-basket-shopping', 'description' => 'Menang dengan BIN sebanyak 50 kali.'],
            ['condition' => 'bin_master', 'name' => 'BIN Master', 'badge_color' => '#f59e0b', 'icon' => 'fa-shopping-bag', 'description' => 'Menang dengan BIN sebanyak 100 kali+.'],

            // Loyal Customer
            ['condition' => 'loyal_rookie', 'name' => 'Loyal Rookie', 'badge_color' => '#422006', 'icon' => 'fa-handshake-angle', 'description' => 'Membeli koi dari 10 lelang berbeda.'],
            ['condition' => 'loyal_pro', 'name' => 'Loyal Pro', 'badge_color' => '#94a3b8', 'icon' => 'fa-hand-holding-heart', 'description' => 'Membeli koi dari 50 lelang berbeda.'],
            ['condition' => 'loyal_master', 'name' => 'Loyal Master', 'badge_color' => '#f59e0b', 'icon' => 'fa-hand-holding-dollar', 'description' => 'Membeli koi dari 100 lelang berbeda.'],

            // Peringkat Top Seller
            ['condition' => 'top_seller_1', 'name' => 'Top Seller #1', 'badge_color' => '#7dd3fc', 'icon' => 'fa-trophy', 'description' => 'Penjual terbaik server.'],
            ['condition' => 'top_seller_2', 'name' => 'Top Seller #2', 'badge_color' => '#7dd3fc', 'icon' => 'fa-medal', 'description' => 'Peringkat kedua penjual.'],
            ['condition' => 'top_seller_3', 'name' => 'Top Seller #3', 'badge_color' => '#7dd3fc', 'icon' => 'fa-medal', 'description' => 'Peringkat ketiga penjual.'],
            ['condition' => 'top_seller_4_10', 'name' => 'Top Seller #4-10', 'badge_color' => '#7dd3fc', 'icon' => 'fa-star', 'description' => 'Penjual top 10 server.'],

            // Peringkat Top Buyer
            ['condition' => 'top_buyer_1', 'name' => 'Top Buyer #1', 'badge_color' => '#7dd3fc', 'icon' => 'fa-trophy', 'description' => 'Pembeli terbaik server.'],
            ['condition' => 'top_buyer_2', 'name' => 'Top Buyer #2', 'badge_color' => '#7dd3fc', 'icon' => 'fa-medal', 'description' => 'Peringkat kedua pembeli.'],
            ['condition' => 'top_buyer_3', 'name' => 'Top Buyer #3', 'badge_color' => '#7dd3fc', 'icon' => 'fa-medal', 'description' => 'Peringkat ketiga pembeli.'],
            ['condition' => 'top_buyer_4_10', 'name' => 'Top Buyer #4-10', 'badge_color' => '#7dd3fc', 'icon' => 'fa-star', 'description' => 'Pembeli top 10 server.']
        ];

        DB::table('achievements')->insert($achievements);
    }
}
