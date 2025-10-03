<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatusHistoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('status_histories')->delete();
        
        \DB::table('status_histories')->insert(array (
            0 => 
            array (
                'id' => 69,
                'transaction_item_id' => 31,
                'status' => 'dikirim',
                'changed_by' => 1,
                'changed_at' => '2025-03-15 15:57:04',
                'created_at' => '2025-03-15 15:57:04',
                'updated_at' => '2025-03-15 15:57:04',
            ),
            1 => 
            array (
                'id' => 70,
                'transaction_item_id' => 31,
                'status' => 'selesai',
                'changed_by' => 5,
                'changed_at' => '2025-03-19 20:09:51',
                'created_at' => '2025-03-19 20:09:51',
                'updated_at' => '2025-03-19 20:09:51',
            ),
            2 => 
            array (
                'id' => 71,
                'transaction_item_id' => 31,
                'status' => 'selesai',
                'changed_by' => 5,
                'changed_at' => '2025-03-19 20:10:01',
                'created_at' => '2025-03-19 20:10:01',
                'updated_at' => '2025-03-19 20:10:01',
            ),
            3 => 
            array (
                'id' => 72,
                'transaction_item_id' => 31,
                'status' => 'selesai',
                'changed_by' => 5,
                'changed_at' => '2025-03-19 20:10:39',
                'created_at' => '2025-03-19 20:10:39',
                'updated_at' => '2025-03-19 20:10:39',
            ),
            4 => 
            array (
                'id' => 73,
                'transaction_item_id' => 31,
                'status' => 'selesai',
                'changed_by' => 5,
                'changed_at' => '2025-03-19 20:15:54',
                'created_at' => '2025-03-19 20:15:54',
                'updated_at' => '2025-03-19 20:15:54',
            ),
            5 => 
            array (
                'id' => 74,
                'transaction_item_id' => 31,
                'status' => 'selesai',
                'changed_by' => 5,
                'changed_at' => '2025-03-19 20:16:00',
                'created_at' => '2025-03-19 20:16:00',
                'updated_at' => '2025-03-19 20:16:00',
            ),
            6 => 
            array (
                'id' => 75,
                'transaction_item_id' => 31,
                'status' => 'selesai',
                'changed_by' => 5,
                'changed_at' => '2025-03-19 20:24:14',
                'created_at' => '2025-03-19 20:24:14',
                'updated_at' => '2025-03-19 20:24:14',
            ),
            7 => 
            array (
                'id' => 76,
                'transaction_item_id' => 31,
                'status' => 'selesai',
                'changed_by' => 5,
                'changed_at' => '2025-03-19 20:29:59',
                'created_at' => '2025-03-19 20:29:59',
                'updated_at' => '2025-03-19 20:29:59',
            ),
            8 => 
            array (
                'id' => 77,
                'transaction_item_id' => 32,
                'status' => 'dikirim',
                'changed_by' => 1,
                'changed_at' => '2025-03-19 21:18:17',
                'created_at' => '2025-03-19 21:18:17',
                'updated_at' => '2025-03-19 21:18:17',
            ),
            9 => 
            array (
                'id' => 78,
                'transaction_item_id' => 32,
                'status' => 'siap dikirim',
                'changed_by' => 1,
                'changed_at' => '2025-03-19 21:23:12',
                'created_at' => '2025-03-19 21:23:12',
                'updated_at' => '2025-03-19 21:23:12',
            ),
            10 => 
            array (
                'id' => 79,
                'transaction_item_id' => 32,
                'status' => 'dikirim',
                'changed_by' => 1,
                'changed_at' => '2025-03-19 21:29:41',
                'created_at' => '2025-03-19 21:29:41',
                'updated_at' => '2025-03-19 21:29:41',
            ),
            11 => 
            array (
                'id' => 80,
                'transaction_item_id' => 32,
                'status' => 'siap dikirim',
                'changed_by' => 1,
                'changed_at' => '2025-03-20 19:46:24',
                'created_at' => '2025-03-20 19:46:24',
                'updated_at' => '2025-03-20 19:46:24',
            ),
            12 => 
            array (
                'id' => 81,
                'transaction_item_id' => 32,
                'status' => 'dikirim',
                'changed_by' => 1,
                'changed_at' => '2025-03-20 19:55:39',
                'created_at' => '2025-03-20 19:55:39',
                'updated_at' => '2025-03-20 19:55:39',
            ),
            13 => 
            array (
                'id' => 82,
                'transaction_item_id' => 32,
                'status' => 'siap dikirim',
                'changed_by' => 1,
                'changed_at' => '2025-03-20 20:10:26',
                'created_at' => '2025-03-20 20:10:26',
                'updated_at' => '2025-03-20 20:10:26',
            ),
            14 => 
            array (
                'id' => 83,
                'transaction_item_id' => 32,
                'status' => 'dikirim',
                'changed_by' => 1,
                'changed_at' => '2025-03-20 20:10:45',
                'created_at' => '2025-03-20 20:10:45',
                'updated_at' => '2025-03-20 20:10:45',
            ),
            15 => 
            array (
                'id' => 84,
                'transaction_item_id' => 32,
                'status' => 'siap dikirim',
                'changed_by' => 1,
                'changed_at' => '2025-03-20 20:33:02',
                'created_at' => '2025-03-20 20:33:02',
                'updated_at' => '2025-03-20 20:33:02',
            ),
            16 => 
            array (
                'id' => 85,
                'transaction_item_id' => 32,
                'status' => 'dikirim',
                'changed_by' => 1,
                'changed_at' => '2025-03-20 20:33:11',
                'created_at' => '2025-03-20 20:33:11',
                'updated_at' => '2025-03-20 20:33:11',
            ),
            17 => 
            array (
                'id' => 86,
                'transaction_item_id' => 32,
                'status' => 'selesai',
                'changed_by' => 5,
                'changed_at' => '2025-03-20 20:42:44',
                'created_at' => '2025-03-20 20:42:44',
                'updated_at' => '2025-03-20 20:42:44',
            ),
            18 => 
            array (
                'id' => 87,
                'transaction_item_id' => 33,
                'status' => 'karantina',
                'changed_by' => 1,
                'changed_at' => '2025-03-22 16:02:46',
                'created_at' => '2025-03-22 16:02:46',
                'updated_at' => '2025-03-22 16:02:46',
            ),
            19 => 
            array (
                'id' => 88,
                'transaction_item_id' => 33,
                'status' => 'dibatalkan',
                'changed_by' => 1,
                'changed_at' => '2025-03-22 16:16:45',
                'created_at' => '2025-03-22 16:16:45',
                'updated_at' => '2025-03-22 16:16:45',
            ),
            20 => 
            array (
                'id' => 89,
                'transaction_item_id' => 33,
                'status' => 'siap dikirim',
                'changed_by' => 1,
                'changed_at' => '2025-03-22 16:40:09',
                'created_at' => '2025-03-22 16:40:09',
                'updated_at' => '2025-03-22 16:40:09',
            ),
            21 => 
            array (
                'id' => 90,
                'transaction_item_id' => 33,
                'status' => 'karantina',
                'changed_by' => 1,
                'changed_at' => '2025-03-22 16:40:43',
                'created_at' => '2025-03-22 16:40:43',
                'updated_at' => '2025-03-22 16:40:43',
            ),
            22 => 
            array (
                'id' => 91,
                'transaction_item_id' => 33,
                'status' => 'karantina',
                'changed_by' => 1,
                'changed_at' => '2025-03-22 16:42:14',
                'created_at' => '2025-03-22 16:42:14',
                'updated_at' => '2025-03-22 16:42:14',
            ),
            23 => 
            array (
                'id' => 92,
                'transaction_item_id' => 33,
                'status' => 'dibatalkan',
                'changed_by' => 1,
                'changed_at' => '2025-03-22 16:42:41',
                'created_at' => '2025-03-22 16:42:41',
                'updated_at' => '2025-03-22 16:42:41',
            ),
            24 => 
            array (
                'id' => 93,
                'transaction_item_id' => 33,
                'status' => 'siap dikirim',
                'changed_by' => 1,
                'changed_at' => '2025-07-17 14:16:43',
                'created_at' => '2025-07-17 14:16:43',
                'updated_at' => '2025-07-17 14:16:43',
            ),
            25 => 
            array (
                'id' => 94,
                'transaction_item_id' => 33,
                'status' => 'dikirim',
                'changed_by' => 1,
                'changed_at' => '2025-07-17 14:16:58',
                'created_at' => '2025-07-17 14:16:58',
                'updated_at' => '2025-07-17 14:16:58',
            ),
        ));
        
        
    }
}