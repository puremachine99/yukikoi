<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransactionItemsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('transaction_items')->delete();
        
        \DB::table('transaction_items')->insert(array (
            0 => 
            array (
                'id' => 31,
                'transaction_id' => 35,
                'buyer_id' => 5,
                'koi_id' => 'RG2410002A',
                'seller_id' => 1,
                'farm' => 'Knight Of Blood Oath',
                'farm_owner_name' => NULL,
                'farm_phone_number' => NULL,
                'price' => '10000000.00',
                'shipping_address' => 'Jl A Yani 519, Purwodadi, RT 5/ RW 24',
                'seller_name' => 'Heathcliff',
                'seller_phone' => '082257111684',
                'shipping_fee' => '150000.00',
                'shipping_group' => 'd3af87bb-4b6c-4a0b-b364-2652570c4384',
                'created_at' => '2025-03-13 18:01:07',
                'updated_at' => '2025-03-19 20:29:59',
                'status' => 'selesai',
                'karantina_reason' => NULL,
                'karantina_end_date' => NULL,
                'cancel_reason' => NULL,
            ),
            1 => 
            array (
                'id' => 32,
                'transaction_id' => 36,
                'buyer_id' => 5,
                'koi_id' => 'RG2410002B',
                'seller_id' => 1,
                'farm' => 'Knight Of Blood Oath',
                'farm_owner_name' => NULL,
                'farm_phone_number' => NULL,
                'price' => '10000000.00',
                'shipping_address' => 'Jl A Yani 519, Purwodadi, RT 5/ RW 24',
                'seller_name' => 'Heathcliff',
                'seller_phone' => '082257111684',
                'shipping_fee' => '250000.00',
                'shipping_group' => 'b8171575-8a8c-4271-8b87-ded059c3e422',
                'created_at' => '2025-03-19 21:17:53',
                'updated_at' => '2025-03-20 20:42:44',
                'status' => 'selesai',
                'karantina_reason' => NULL,
                'karantina_end_date' => NULL,
                'cancel_reason' => NULL,
            ),
            2 => 
            array (
                'id' => 33,
                'transaction_id' => 37,
                'buyer_id' => 5,
                'koi_id' => 'RG2410002C',
                'seller_id' => 1,
                'farm' => 'Knight Of Blood Oath',
                'farm_owner_name' => NULL,
                'farm_phone_number' => NULL,
                'price' => '10000000.00',
                'shipping_address' => 'Jl A Yani 519, Purwodadi, RT 5/ RW 24',
                'seller_name' => 'Heathcliff',
                'seller_phone' => '082257111684',
                'shipping_fee' => '150000.00',
                'shipping_group' => '3ffccea0-3076-4d05-87cc-dbd9d07d69bc',
                'created_at' => '2025-03-22 14:41:36',
                'updated_at' => '2025-07-17 14:16:58',
                'status' => 'dikirim',
            'karantina_reason' => 'Ikan Buang Kotoran (3 hari)',
                'karantina_end_date' => '2025-03-25',
                'cancel_reason' => '{"reason":"Ikan Mati","video_url":"/storage/videos/op4culPdcRps2BrTtMLRLqCwLECP9G9n6LJixYAn.mp4"}',
            ),
            3 => 
            array (
                'id' => 34,
                'transaction_id' => 38,
                'buyer_id' => 1,
                'koi_id' => 'RG2409009E',
                'seller_id' => 4,
                'farm' => 'Ali Farm',
                'farm_owner_name' => NULL,
                'farm_phone_number' => NULL,
                'price' => '10000000.00',
                'shipping_address' => 'jl besi no 1 kav 1, RT 5, RW 24, Purwantoro, Blimbing',
                'seller_name' => 'Ali Hoffman',
                'seller_phone' => '082257111688',
                'shipping_fee' => '99000.00',
                'shipping_group' => '32bdc7e4-d030-4d6e-aa58-804e479f3053',
                'created_at' => '2025-05-26 15:49:01',
                'updated_at' => '2025-05-26 15:49:01',
                'status' => 'menunggu konfirmasi',
                'karantina_reason' => NULL,
                'karantina_end_date' => NULL,
                'cancel_reason' => NULL,
            ),
        ));
        
        
    }
}