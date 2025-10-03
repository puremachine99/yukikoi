<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AchievementsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('achievements')->delete();
        
        \DB::table('achievements')->insert(array (
            0 => 
            array (
                'id' => 55,
                'name' => 'Seller Rookie',
                'icon' => 'fa-star',
                'badge_color' => '#422006',
                'description' => 'Penghasilan Rp20 juta.',
                'condition' => 'seller_rookie_income',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 56,
                'name' => 'Seller Pro',
                'icon' => 'fa-trophy',
                'badge_color' => '#94a3b8',
                'description' => 'Penghasilan Rp100 juta.',
                'condition' => 'seller_pro_income',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 57,
                'name' => 'Seller Veteran',
                'icon' => 'fa-crown',
                'badge_color' => '#f59e0b',
                'description' => 'Penghasilan Rp500 juta+.',
                'condition' => 'seller_veteran_income',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 58,
                'name' => 'Bos',
                'icon' => 'fa-coins',
                'badge_color' => '#422006',
                'description' => 'Pengeluaran Rp10 juta.',
                'condition' => 'small_spender',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 59,
                'name' => 'Juragan',
                'icon' => 'fa-wallet',
                'badge_color' => '#94a3b8',
                'description' => 'Pengeluaran Rp50 juta.',
                'condition' => 'big_spender',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 60,
                'name' => 'Sultan',
                'icon' => 'fa-landmark',
                'badge_color' => '#f59e0b',
                'description' => 'Pengeluaran Rp100 juta+.',
                'condition' => 'elite_spender',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 61,
                'name' => 'Collector Rookie',
                'icon' => 'fa-fish',
                'badge_color' => '#422006',
                'description' => 'Membeli 10 koi.',
                'condition' => 'collector_rookie',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 62,
                'name' => 'Collector Pro',
                'icon' => 'fa-box',
                'badge_color' => '#94a3b8',
                'description' => 'Membeli 50 koi.',
                'condition' => 'collector_pro',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 63,
                'name' => 'Collector Master',
                'icon' => 'fa-gem',
                'badge_color' => '#f59e0b',
                'description' => 'Membeli 100 koi+.',
                'condition' => 'collector_master',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 64,
                'name' => 'Seller Rookie',
                'icon' => 'fa-handshake',
                'badge_color' => '#422006',
                'description' => 'Menjual 50 koi.',
                'condition' => 'seller_rookie_sold',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 65,
                'name' => 'Seller Pro',
                'icon' => 'fa-dolly',
                'badge_color' => '#94a3b8',
                'description' => 'Menjual 250 koi.',
                'condition' => 'seller_pro_sold',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 66,
                'name' => 'Seller Master',
                'icon' => 'fa-store',
                'badge_color' => '#f59e0b',
                'description' => 'Menjual 1000 koi+.',
                'condition' => 'seller_master_sold',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 67,
                'name' => 'Sniper Rookie',
                'icon' => 'fa-crosshairs',
                'badge_color' => '#422006',
                'description' => 'Menang di menit terakhir pada 10 lelang.',
                'condition' => 'sniper_rookie',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 68,
                'name' => 'Sniper Pro',
                'icon' => 'fa-bullseye',
                'badge_color' => '#94a3b8',
                'description' => 'Menang di menit terakhir pada 50 lelang.',
                'condition' => 'sniper_pro',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 69,
                'name' => 'Sniper Master',
                'icon' => 'fa-hat-cowboy',
                'badge_color' => '#f59e0b',
                'description' => 'Menang di menit terakhir pada 1000 lelang+.',
                'condition' => 'sniper_master',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 70,
                'name' => 'BIN Rookie',
                'icon' => 'fa-cart-shopping',
                'badge_color' => '#422006',
                'description' => 'Menang dengan BIN sebanyak 10 kali.',
                'condition' => 'bin_rookie',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 71,
                'name' => 'BIN Pro',
                'icon' => 'fa-basket-shopping',
                'badge_color' => '#94a3b8',
                'description' => 'Menang dengan BIN sebanyak 50 kali.',
                'condition' => 'bin_pro',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 72,
                'name' => 'BIN Master',
                'icon' => 'fa-shopping-bag',
                'badge_color' => '#f59e0b',
                'description' => 'Menang dengan BIN sebanyak 1000 kali+.',
                'condition' => 'bin_master',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 73,
                'name' => 'Loyal Rookie',
                'icon' => 'fa-handshake-angle',
                'badge_color' => '#422006',
                'description' => 'Membeli koi dari 10 lelang berbeda.',
                'condition' => 'loyal_rookie',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 74,
                'name' => 'Loyal Pro',
                'icon' => 'fa-hand-holding-heart',
                'badge_color' => '#94a3b8',
                'description' => 'Membeli koi dari 50 lelang berbeda.',
                'condition' => 'loyal_pro',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 75,
                'name' => 'Loyal Master',
                'icon' => 'fa-hand-holding-dollar',
                'badge_color' => '#f59e0b',
                'description' => 'Membeli koi dari 1000 lelang berbeda.',
                'condition' => 'loyal_master',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 76,
                'name' => 'Top Seller #1',
                'icon' => 'fa-trophy',
                'badge_color' => '#7dd3fc',
                'description' => 'Penjual terbaik server.',
                'condition' => 'top_seller_1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 77,
                'name' => 'Top Seller #2',
                'icon' => 'fa-medal',
                'badge_color' => '#7dd3fc',
                'description' => 'Peringkat kedua penjual.',
                'condition' => 'top_seller_2',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 78,
                'name' => 'Top Seller #3',
                'icon' => 'fa-medal',
                'badge_color' => '#7dd3fc',
                'description' => 'Peringkat ketiga penjual.',
                'condition' => 'top_seller_3',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 79,
                'name' => 'Top Seller #4-10',
                'icon' => 'fa-star',
                'badge_color' => '#7dd3fc',
                'description' => 'Penjual top 10 server.',
                'condition' => 'top_seller_4_10',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 80,
                'name' => 'Top Buyer #1',
                'icon' => 'fa-trophy',
                'badge_color' => '#7dd3fc',
                'description' => 'Pembeli terbaik server.',
                'condition' => 'top_buyer_1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 81,
                'name' => 'Top Buyer #2',
                'icon' => 'fa-medal',
                'badge_color' => '#7dd3fc',
                'description' => 'Peringkat kedua pembeli.',
                'condition' => 'top_buyer_2',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 82,
                'name' => 'Top Buyer #3',
                'icon' => 'fa-medal',
                'badge_color' => '#7dd3fc',
                'description' => 'Peringkat ketiga pembeli.',
                'condition' => 'top_buyer_3',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 83,
                'name' => 'Top Buyer #4-10',
                'icon' => 'fa-star',
                'badge_color' => '#7dd3fc',
                'description' => 'Pembeli top 10 server.',
                'condition' => 'top_buyer_4_10',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 84,
                'name' => 'Premium User',
                'icon' => 'fa-user-check',
                'badge_color' => '#6366f1',
                'description' => 'Kontributor.',
                'condition' => 'top_buyer_4_10',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 85,
                'name' => 'Azukari Rookie',
                'icon' => 'fa-seedling',
                'badge_color' => '#422006',
                'description' => 'Mengikuti 10 Event Azukari',
                'condition' => 'collector_rookie',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 86,
                'name' => 'Azukari Pro',
                'icon' => 'fa-seedling',
                'badge_color' => '#94a3b8',
                'description' => 'Mengikuti 30 Event Azukari',
                'condition' => 'collector_pro',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 87,
                'name' => 'Azukari Master',
                'icon' => 'fa-seedling',
                'badge_color' => '#f59e0b',
                'description' => 'Mengikuti 50 Event Azukari',
                'condition' => 'collector_master',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 88,
                'name' => 'Keeping Contest Rookie',
                'icon' => 'fa-shield-heart',
                'badge_color' => '#422006',
                'description' => 'Mengikuti 10 Event Keeping Contest',
                'condition' => 'collector_rookie',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 89,
                'name' => 'Keeping Contest Pro',
                'icon' => 'fa-shield-heart',
                'badge_color' => '#94a3b8',
                'description' => 'Mengikuti 30 Event Keeping Contest',
                'condition' => 'collector_pro',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 90,
                'name' => 'Keeping Contest Master',
                'icon' => 'fa-shield-heart',
                'badge_color' => '#f59e0b',
                'description' => 'Mengikuti 50 Event Keeping Contest',
                'condition' => 'collector_master',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 91,
                'name' => 'Grow Out Rookie',
                'icon' => 'fa-plate-wheat',
                'badge_color' => '#422006',
                'description' => 'Mengikuti 10 Event Grow Out',
                'condition' => 'collector_rookie',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 92,
                'name' => 'Grow Out Pro',
                'icon' => 'fa-plate-wheat',
                'badge_color' => '#94a3b8',
                'description' => 'Mengikuti 30 Event Grow Out',
                'condition' => 'collector_pro',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 93,
                'name' => 'Grow Out Master',
                'icon' => 'fa-plate-wheat',
                'badge_color' => '#f59e0b',
                'description' => 'Mengikuti 50 Event Grow Out',
                'condition' => 'collector_master',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 94,
                'name' => 'Top Global #1',
                'icon' => 'fa-chess-queen',
                'badge_color' => '#818cf8',
                'description' => '#1 Buyer Event + Reguler terbaik server.',
                'condition' => 'top_seller_1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 95,
                'name' => 'Top Global #2',
                'icon' => 'fa-earth-asia',
                'badge_color' => '#818cf8',
                'description' => '#2 Buyer Event + Reguler terbaik server.',
                'condition' => 'top_seller_2',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 96,
                'name' => 'Top Global #3',
                'icon' => 'fa-earth-asia',
                'badge_color' => '#818cf8',
                'description' => '#3 Buyer Event + Reguler terbaik server.',
                'condition' => 'top_seller_3',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 97,
                'name' => 'Top Local #1',
                'icon' => 'fa-chess-queen',
                'badge_color' => '#34d399',
                'description' => '#1 Buyer Reguler terbaik server.',
                'condition' => 'top_seller_1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 98,
                'name' => 'Top Local #2',
                'icon' => 'fa-house-flag',
                'badge_color' => '#34d399',
                'description' => '#2 Buyer Reguler terbaik server.',
                'condition' => 'top_seller_2',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 99,
                'name' => 'Top Local #3',
                'icon' => 'fa-house-flag',
                'badge_color' => '#34d399',
                'description' => '#3 Buyer Reguler terbaik server.',
                'condition' => 'top_seller_3',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 100,
                'name' => 'Top Rival #1',
                'icon' => 'fa-chess-queen',
                'badge_color' => '#38bdf8',
                'description' => '#1 Buyer Event terbaik server.',
                'condition' => 'top_seller_1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 101,
                'name' => 'Top Rival #2',
                'icon' => 'fa-hand-fist',
                'badge_color' => '#38bdf8',
                'description' => '#2 Buyer Event terbaik server.',
                'condition' => 'top_seller_2',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 102,
                'name' => 'Top Rival #3',
                'icon' => 'fa-hand-fist',
                'badge_color' => '#38bdf8',
                'description' => '#3 Buyer Event terbaik server.',
                'condition' => 'top_seller_3',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}