<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AuctionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('auctions')->delete();
        
        \DB::table('auctions')->insert(array (
            0 => 
            array (
                'auction_code' => 'RG2409008',
                'title' => 'Auction',
                'description' => 'Test Leleang Lama',
                'jenis' => 'reguler',
                'status' => 'on going',
                'start_time' => '2024-09-15 09:17:00',
                'end_time' => '2025-12-30 13:40:00',
                'extra_time' => 0,
                'contest_time' => NULL,
                'banner' => 'banner_auctions/H8OqhGCwMoAAMwIWKDa34rGN4fDmVbmkSHbAcnR9.jpg',
                'user_id' => 3,
                'created_at' => '2024-09-15 09:16:08',
                'updated_at' => '2025-07-17 09:42:00',
            ),
            1 => 
            array (
                'auction_code' => 'RG2409009',
                'title' => 'Auction Ali',
                'description' => 'asdfasdfasdf',
                'jenis' => 'reguler',
                'status' => 'on going',
                'start_time' => '2024-09-16 11:59:00',
                'end_time' => '2025-12-30 13:40:00',
                'extra_time' => 0,
                'contest_time' => NULL,
                'banner' => 'banner_auctions/LZVgKJQoQY9rjjH6cAdLAYpBuWwrpVVt4dnFpsbM.jpg',
                'user_id' => 4,
                'created_at' => '2024-09-15 11:59:23',
                'updated_at' => '2025-07-17 09:42:01',
            ),
            2 => 
            array (
                'auction_code' => 'RG2409010',
                'title' => 'Auction Test Auto',
                'description' => 'test Auto lelang',
                'jenis' => 'reguler',
                'status' => 'on going',
                'start_time' => '2024-09-15 14:48:00',
                'end_time' => '2025-12-30 13:40:00',
                'extra_time' => 0,
                'contest_time' => NULL,
                'banner' => 'banner_auctions/5TMQWagad4XF2psrNhgk769mnA7niroJdje17ev9.jpg',
                'user_id' => 4,
                'created_at' => '2024-09-15 14:46:29',
                'updated_at' => '2025-07-17 09:42:01',
            ),
            3 => 
            array (
                'auction_code' => 'RG2409011',
                'title' => 'Auction F',
                'description' => 'haha',
                'jenis' => 'reguler',
                'status' => 'on going',
                'start_time' => '2024-09-24 10:25:00',
                'end_time' => '2025-12-30 13:40:00',
                'extra_time' => 0,
                'contest_time' => NULL,
                'banner' => 'banner_auctions/w486gbsf20pDnavkLLD6GWuDdJQqOu4i9EOnRy5x.jpg',
                'user_id' => 5,
                'created_at' => '2024-09-24 10:26:45',
                'updated_at' => '2025-07-17 09:42:01',
            ),
            4 => 
            array (
                'auction_code' => 'RG2410002',
            'title' => 'Lelang Uji Coba (7Hari)',
                'description' => 'Lelang tahunan yuki Koi Auction ke 5',
                'jenis' => 'reguler',
                'status' => 'on going',
                'start_time' => '2024-09-24 10:25:00',
                'end_time' => '2025-12-30 13:40:00',
                'extra_time' => 0,
                'contest_time' => NULL,
                'banner' => 'banner_auctions/FK0d1rmlcMxb4uglHpoErCfvInHZnzID0JfiUf59.jpg',
                'user_id' => 1,
                'created_at' => '2024-10-23 14:29:03',
                'updated_at' => '2025-07-17 09:42:03',
            ),
            5 => 
            array (
                'auction_code' => 'RG2410003',
                'title' => 'Lelang tahun ke 2',
                'description' => 'Lelang percobaan ke 2',
                'jenis' => 'reguler',
                'status' => 'on going',
                'start_time' => '2024-10-27 15:10:00',
                'end_time' => '2025-12-30 13:40:00',
                'extra_time' => 0,
                'contest_time' => NULL,
                'banner' => 'banner_auctions/tYFn8VqzmVJLUQTgqmbGWUWBvuB0YvV0VgRvJU2L.png',
                'user_id' => 1,
                'created_at' => '2024-10-27 14:54:53',
                'updated_at' => '2025-07-17 09:42:03',
            ),
            6 => 
            array (
                'auction_code' => 'RG2411001',
                'title' => '1 Auction',
                'description' => 'Lelang ketika lelang',
                'jenis' => 'reguler',
                'status' => 'on going',
                'start_time' => '2024-11-17 09:08:00',
                'end_time' => '2025-12-30 13:40:00',
                'extra_time' => 0,
                'contest_time' => NULL,
                'banner' => 'banner_auctions/QZK92fKnOcaU9zGBSEaPDTkpp1R3iiKvmRZOiDLM.jpg',
                'user_id' => 5,
                'created_at' => '2024-11-17 09:05:42',
                'updated_at' => '2025-07-17 09:42:04',
            ),
            7 => 
            array (
                'auction_code' => 'RG2412001',
                'title' => 'Knight Of Blood Oath Auction',
                'description' => 'test lelang',
                'jenis' => 'reguler',
                'status' => 'on going',
                'start_time' => '2025-02-13 14:30:00',
                'end_time' => '2025-12-30 13:40:00',
                'extra_time' => 0,
                'contest_time' => NULL,
                'banner' => 'banner_auctions/wmEgRy7YmbCK6zcwqxWK5HbJLIrTKnpgenigS5s7.jpg',
                'user_id' => 1,
                'created_at' => '2024-12-10 11:24:43',
                'updated_at' => '2025-07-17 09:42:04',
            ),
            8 => 
            array (
                'auction_code' => 'RG2502001',
                'title' => 'Buat lelang 2',
                'description' => 'tetst',
                'jenis' => 'reguler',
                'status' => 'on going',
                'start_time' => '2025-02-03 16:14:00',
                'end_time' => '2025-12-30 13:40:00',
                'extra_time' => 0,
                'contest_time' => NULL,
                'banner' => 'banner_auctions/Y0TDr2PGjAsSMlOZi5Rm5sFGTmKec8kcanY1VSmM.jpg',
                'user_id' => 1,
                'created_at' => '2025-02-03 15:13:15',
                'updated_at' => '2025-07-17 09:42:05',
            ),
            9 => 
            array (
                'auction_code' => 'RG2507001',
                'title' => 'Lelang test 2025',
                'description' => 'Lelang test with yusuf',
                'jenis' => 'reguler',
                'status' => 'draft',
                'start_time' => '2025-07-05 17:10:00',
                'end_time' => '2025-12-30 13:40:00',
                'extra_time' => 0,
                'contest_time' => NULL,
                'banner' => 'banner_auctions/jHJ8lE2hpz8ZMyullSd6VAOsUTMKlyXqIYzoTef0.png',
                'user_id' => 1,
                'created_at' => '2025-07-05 17:07:25',
                'updated_at' => '2025-07-05 17:07:25',
            ),
        ));
        
        
    }
}
