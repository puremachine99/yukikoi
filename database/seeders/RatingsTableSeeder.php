<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RatingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ratings')->delete();
        
        \DB::table('ratings')->insert(array (
            0 => 
            array (
                'id' => 3,
                'transaction_item_id' => 31,
                'buyer_id' => 5,
                'seller_id' => 1,
                'rating_quality' => 5,
                'rating_shipping' => 3,
                'rating_service' => 5,
                'review' => 'Mantap , seller ramah, ikan sampai tujuan selamat dan on time. trusted Seller',
                'created_at' => '2025-03-15 19:22:34',
                'updated_at' => '2025-03-19 20:30:19',
            ),
            1 => 
            array (
                'id' => 4,
                'transaction_item_id' => 32,
                'buyer_id' => 5,
                'seller_id' => 1,
                'rating_quality' => 5,
                'rating_shipping' => 5,
                'rating_service' => 5,
                'review' => NULL,
                'created_at' => '2025-03-20 20:42:51',
                'updated_at' => '2025-03-20 20:42:51',
            ),
        ));
        
        
    }
}