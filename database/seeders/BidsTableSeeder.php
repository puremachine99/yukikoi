<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BidsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('bids')->delete();
        
        \DB::table('bids')->insert(array (
            0 => 
            array (
                'id' => 145,
                'koi_id' => 'RG2410002A',
                'user_id' => 5,
                'amount' => '10000.00',
                'is_win' => 1,
                'is_bin' => 1,
                'is_sniping' => 0,
                'created_at' => '2025-03-13 18:00:50',
                'updated_at' => '2025-03-13 18:00:50',
            ),
            1 => 
            array (
                'id' => 146,
                'koi_id' => 'RG2411001A',
                'user_id' => 1,
                'amount' => '79.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-03-13 19:43:05',
                'updated_at' => '2025-03-13 19:43:05',
            ),
            2 => 
            array (
                'id' => 147,
                'koi_id' => 'RG2411001A',
                'user_id' => 1,
                'amount' => '140.00',
                'is_win' => 1,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-03-13 19:43:19',
                'updated_at' => '2025-04-24 14:04:03',
            ),
            3 => 
            array (
                'id' => 148,
                'koi_id' => 'RG2410002B',
                'user_id' => 5,
                'amount' => '350.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-03-19 21:04:57',
                'updated_at' => '2025-03-19 21:04:57',
            ),
            4 => 
            array (
                'id' => 149,
                'koi_id' => 'RG2410002B',
                'user_id' => 5,
                'amount' => '425.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-03-19 21:05:28',
                'updated_at' => '2025-03-19 21:05:28',
            ),
            5 => 
            array (
                'id' => 150,
                'koi_id' => 'RG2410002B',
                'user_id' => 5,
                'amount' => '10000.00',
                'is_win' => 1,
                'is_bin' => 1,
                'is_sniping' => 0,
                'created_at' => '2025-03-19 21:05:38',
                'updated_at' => '2025-03-19 21:05:38',
            ),
            6 => 
            array (
                'id' => 151,
                'koi_id' => 'RG2410002C',
                'user_id' => 5,
                'amount' => '400.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-03-22 14:35:43',
                'updated_at' => '2025-03-22 14:35:43',
            ),
            7 => 
            array (
                'id' => 152,
                'koi_id' => 'RG2410002C',
                'user_id' => 5,
                'amount' => '450.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-03-22 14:35:51',
                'updated_at' => '2025-03-22 14:35:51',
            ),
            8 => 
            array (
                'id' => 153,
                'koi_id' => 'RG2410002C',
                'user_id' => 5,
                'amount' => '500.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-03-22 14:40:29',
                'updated_at' => '2025-03-22 14:40:29',
            ),
            9 => 
            array (
                'id' => 154,
                'koi_id' => 'RG2410002C',
                'user_id' => 5,
                'amount' => '10000.00',
                'is_win' => 1,
                'is_bin' => 1,
                'is_sniping' => 0,
                'created_at' => '2025-03-22 14:40:38',
                'updated_at' => '2025-03-22 14:40:38',
            ),
            10 => 
            array (
                'id' => 155,
                'koi_id' => 'RG2410003D',
                'user_id' => 5,
                'amount' => '650.00',
                'is_win' => 1,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-03-25 02:57:19',
                'updated_at' => '2025-07-17 09:42:04',
            ),
            11 => 
            array (
                'id' => 156,
                'koi_id' => 'RG2411001A',
                'user_id' => 2,
                'amount' => '201.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-05-20 17:24:47',
                'updated_at' => '2025-05-20 17:24:47',
            ),
            12 => 
            array (
                'id' => 157,
                'koi_id' => 'RG2411001A',
                'user_id' => 1,
                'amount' => '262.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-05-23 11:50:27',
                'updated_at' => '2025-05-23 11:50:27',
            ),
            13 => 
            array (
                'id' => 158,
                'koi_id' => 'RG2411001A',
                'user_id' => 2,
                'amount' => '323.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-05-23 11:50:33',
                'updated_at' => '2025-05-23 11:50:33',
            ),
            14 => 
            array (
                'id' => 159,
                'koi_id' => 'RG2411001A',
                'user_id' => 1,
                'amount' => '445.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-05-23 11:52:10',
                'updated_at' => '2025-05-23 11:52:10',
            ),
            15 => 
            array (
                'id' => 160,
                'koi_id' => 'RG2411001A',
                'user_id' => 1,
                'amount' => '506.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-05-23 11:53:46',
                'updated_at' => '2025-05-23 11:53:46',
            ),
            16 => 
            array (
                'id' => 161,
                'koi_id' => 'RG2409009E',
                'user_id' => 2,
                'amount' => '15.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-05-23 11:54:27',
                'updated_at' => '2025-05-23 11:54:27',
            ),
            17 => 
            array (
                'id' => 162,
                'koi_id' => 'RG2409009E',
                'user_id' => 1,
                'amount' => '71.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-05-23 11:54:39',
                'updated_at' => '2025-05-23 11:54:39',
            ),
            18 => 
            array (
                'id' => 163,
                'koi_id' => 'RG2409009E',
                'user_id' => 2,
                'amount' => '127.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-05-23 11:54:47',
                'updated_at' => '2025-05-23 11:54:47',
            ),
            19 => 
            array (
                'id' => 164,
                'koi_id' => 'RG2411001A',
                'user_id' => 1,
                'amount' => '567.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-05-26 15:46:36',
                'updated_at' => '2025-05-26 15:46:36',
            ),
            20 => 
            array (
                'id' => 165,
                'koi_id' => 'RG2409009E',
                'user_id' => 1,
                'amount' => '10000.00',
                'is_win' => 1,
                'is_bin' => 1,
                'is_sniping' => 0,
                'created_at' => '2025-05-26 15:48:32',
                'updated_at' => '2025-05-26 15:48:32',
            ),
            21 => 
            array (
                'id' => 166,
                'koi_id' => 'RG2411001A',
                'user_id' => 1,
                'amount' => '10000.00',
                'is_win' => 1,
                'is_bin' => 1,
                'is_sniping' => 0,
                'created_at' => '2025-05-26 18:06:02',
                'updated_at' => '2025-05-26 18:06:02',
            ),
            22 => 
            array (
                'id' => 167,
                'koi_id' => 'RG2409011C',
                'user_id' => 1,
                'amount' => '260.00',
                'is_win' => 1,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-05-26 18:06:19',
                'updated_at' => '2025-07-17 09:42:03',
            ),
            23 => 
            array (
                'id' => 168,
                'koi_id' => 'RG2409011B',
                'user_id' => 1,
                'amount' => '66.00',
                'is_win' => 1,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-06-05 10:43:05',
                'updated_at' => '2025-07-17 09:42:01',
            ),
            24 => 
            array (
                'id' => 169,
                'koi_id' => 'RG2409009D',
                'user_id' => 1,
                'amount' => '89.00',
                'is_win' => 0,
                'is_bin' => 0,
                'is_sniping' => 0,
                'created_at' => '2025-06-15 17:02:44',
                'updated_at' => '2025-06-15 17:02:44',
            ),
            25 => 
            array (
                'id' => 170,
                'koi_id' => 'RG2409009D',
                'user_id' => 1,
                'amount' => '10000.00',
                'is_win' => 1,
                'is_bin' => 1,
                'is_sniping' => 0,
                'created_at' => '2025-06-15 17:03:04',
                'updated_at' => '2025-06-15 17:03:04',
            ),
        ));
        
        
    }
}