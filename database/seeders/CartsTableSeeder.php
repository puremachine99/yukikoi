<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CartsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('carts')->delete();
        
        \DB::table('carts')->insert(array (
            0 => 
            array (
                'id' => 71,
                'user_id' => 1,
                'koi_id' => 'RG2411001A',
                'auction_name' => '1 Auction',
                'price' => '10000000.00',
                'is_processed' => 0,
                'created_at' => '2025-05-26 18:06:02',
                'updated_at' => '2025-05-26 18:06:02',
            ),
            1 => 
            array (
                'id' => 72,
                'user_id' => 1,
                'koi_id' => 'RG2409009D',
                'auction_name' => 'Auction Ali',
                'price' => '10000000.00',
                'is_processed' => 0,
                'created_at' => '2025-06-15 17:03:04',
                'updated_at' => '2025-06-15 17:03:04',
            ),
        ));
        
        
    }
}