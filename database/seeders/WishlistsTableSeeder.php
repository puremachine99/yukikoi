<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WishlistsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('wishlists')->delete();
        
        \DB::table('wishlists')->insert(array (
            0 => 
            array (
                'id' => 37,
                'user_id' => 1,
                'koi_id' => 'RG2409009E',
                'created_at' => '2025-03-13 19:51:32',
                'updated_at' => '2025-03-13 19:51:32',
            ),
            1 => 
            array (
                'id' => 38,
                'user_id' => 5,
                'koi_id' => 'RG2410002C',
                'created_at' => '2025-03-22 14:35:32',
                'updated_at' => '2025-03-22 14:35:32',
            ),
            2 => 
            array (
                'id' => 39,
                'user_id' => 5,
                'koi_id' => 'RG2410002B',
                'created_at' => '2025-03-23 05:53:02',
                'updated_at' => '2025-03-23 05:53:02',
            ),
            3 => 
            array (
                'id' => 40,
                'user_id' => 1,
                'koi_id' => 'RG2409011C',
                'created_at' => '2025-03-23 06:04:09',
                'updated_at' => '2025-03-23 06:04:09',
            ),
            4 => 
            array (
                'id' => 41,
                'user_id' => 1,
                'koi_id' => 'RG2410002A',
                'created_at' => '2025-03-23 06:04:41',
                'updated_at' => '2025-03-23 06:04:41',
            ),
            5 => 
            array (
                'id' => 43,
                'user_id' => 5,
                'koi_id' => 'RG2410003D',
                'created_at' => '2025-03-24 22:49:20',
                'updated_at' => '2025-03-24 22:49:20',
            ),
            6 => 
            array (
                'id' => 46,
                'user_id' => 1,
                'koi_id' => 'RG2412001A',
                'created_at' => '2025-05-26 16:00:24',
                'updated_at' => '2025-05-26 16:00:24',
            ),
            7 => 
            array (
                'id' => 47,
                'user_id' => 1,
                'koi_id' => 'RG2409011B',
                'created_at' => '2025-07-26 14:59:45',
                'updated_at' => '2025-07-26 14:59:45',
            ),
            8 => 
            array (
                'id' => 48,
                'user_id' => 3,
                'koi_id' => 'RG2411001B',
                'created_at' => '2025-07-26 15:05:11',
                'updated_at' => '2025-07-26 15:05:11',
            ),
        ));
        
        
    }
}