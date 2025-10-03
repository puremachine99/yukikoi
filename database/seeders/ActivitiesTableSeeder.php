<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('activities')->delete();
        
        \DB::table('activities')->insert(array (
            0 => 
            array (
                'id' => 94,
                'user_id' => 1,
                'koi_id' => 'RG2409009E',
                'activity_type' => 'like',
                'weight' => '2.00',
                'created_at' => '2025-03-13 16:57:04',
                'updated_at' => '2025-03-13 16:57:04',
            ),
            1 => 
            array (
                'id' => 95,
                'user_id' => 1,
                'koi_id' => 'RG2411001A',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-03-13 16:57:04',
                'updated_at' => '2025-03-13 16:57:04',
            ),
            2 => 
            array (
                'id' => 96,
                'user_id' => 1,
                'koi_id' => 'RG2411001A',
                'activity_type' => 'like',
                'weight' => '2.00',
                'created_at' => '2025-03-13 16:57:05',
                'updated_at' => '2025-03-13 16:57:05',
            ),
            3 => 
            array (
                'id' => 100,
                'user_id' => 5,
                'koi_id' => 'RG2410002A',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-03-13 18:00:46',
                'updated_at' => '2025-03-13 18:00:46',
            ),
            4 => 
            array (
                'id' => 101,
                'user_id' => 1,
                'koi_id' => 'RG2410002C',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-03-13 19:47:48',
                'updated_at' => '2025-03-13 19:47:48',
            ),
            5 => 
            array (
                'id' => 102,
                'user_id' => 1,
                'koi_id' => 'RG2409009E',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-03-13 19:50:12',
                'updated_at' => '2025-03-13 19:50:12',
            ),
            6 => 
            array (
                'id' => 103,
                'user_id' => 1,
                'koi_id' => 'RG2409011C',
                'activity_type' => 'like',
                'weight' => '2.00',
                'created_at' => '2025-03-13 19:54:03',
                'updated_at' => '2025-03-13 19:54:03',
            ),
            7 => 
            array (
                'id' => 104,
                'user_id' => 1,
                'koi_id' => 'RG2409011C',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-03-13 19:54:06',
                'updated_at' => '2025-03-13 19:54:06',
            ),
            8 => 
            array (
                'id' => 105,
                'user_id' => 1,
                'koi_id' => 'RG2410002A',
                'activity_type' => 'like',
                'weight' => '2.00',
                'created_at' => '2025-03-15 19:56:56',
                'updated_at' => '2025-03-15 19:56:56',
            ),
            9 => 
            array (
                'id' => 106,
                'user_id' => 1,
                'koi_id' => 'RG2410002B',
                'activity_type' => 'like',
                'weight' => '2.00',
                'created_at' => '2025-03-15 19:56:58',
                'updated_at' => '2025-03-15 19:56:58',
            ),
            10 => 
            array (
                'id' => 107,
                'user_id' => 5,
                'koi_id' => 'RG2410002B',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-03-19 21:04:53',
                'updated_at' => '2025-03-19 21:04:53',
            ),
            11 => 
            array (
                'id' => 108,
                'user_id' => 5,
                'koi_id' => 'RG2410002C',
                'activity_type' => 'like',
                'weight' => '2.00',
                'created_at' => '2025-03-22 14:35:31',
                'updated_at' => '2025-03-22 14:35:31',
            ),
            12 => 
            array (
                'id' => 109,
                'user_id' => 5,
                'koi_id' => 'RG2409011C',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-03-22 21:19:44',
                'updated_at' => '2025-03-22 21:19:44',
            ),
            13 => 
            array (
                'id' => 110,
                'user_id' => 5,
                'koi_id' => 'RG2410002A',
                'activity_type' => 'like',
                'weight' => '2.00',
                'created_at' => '2025-03-23 04:34:14',
                'updated_at' => '2025-03-23 04:34:14',
            ),
            14 => 
            array (
                'id' => 111,
                'user_id' => 5,
                'koi_id' => 'RG2410002B',
                'activity_type' => 'like',
                'weight' => '2.00',
                'created_at' => '2025-03-23 04:34:15',
                'updated_at' => '2025-03-23 04:34:15',
            ),
            15 => 
            array (
                'id' => 112,
                'user_id' => 2,
                'koi_id' => 'RG2410002A',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-03-23 05:55:58',
                'updated_at' => '2025-03-23 05:55:58',
            ),
            16 => 
            array (
                'id' => 113,
                'user_id' => 2,
                'koi_id' => 'RG2410002B',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-03-23 05:56:13',
                'updated_at' => '2025-03-23 05:56:13',
            ),
            17 => 
            array (
                'id' => 114,
                'user_id' => 2,
                'koi_id' => 'RG2410002C',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-03-23 05:56:26',
                'updated_at' => '2025-03-23 05:56:26',
            ),
            18 => 
            array (
                'id' => 115,
                'user_id' => 1,
                'koi_id' => 'RG2410003C',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-03-23 08:13:04',
                'updated_at' => '2025-03-23 08:13:04',
            ),
            19 => 
            array (
                'id' => 116,
                'user_id' => 1,
                'koi_id' => 'RG2410003A',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-03-24 22:48:44',
                'updated_at' => '2025-03-24 22:48:44',
            ),
            20 => 
            array (
                'id' => 117,
                'user_id' => 5,
                'koi_id' => 'RG2410003D',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-03-25 02:57:14',
                'updated_at' => '2025-03-25 02:57:14',
            ),
            21 => 
            array (
                'id' => 118,
                'user_id' => 5,
                'koi_id' => 'RG2412001B',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-03-25 10:07:52',
                'updated_at' => '2025-03-25 10:07:52',
            ),
            22 => 
            array (
                'id' => 119,
                'user_id' => 1,
                'koi_id' => 'RG2410003A',
                'activity_type' => 'like',
                'weight' => '1.00',
                'created_at' => '2025-05-20 12:27:32',
                'updated_at' => '2025-05-20 12:27:32',
            ),
            23 => 
            array (
                'id' => 120,
                'user_id' => 1,
                'koi_id' => 'RG2410002A',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-05-20 16:02:23',
                'updated_at' => '2025-05-20 16:02:23',
            ),
            24 => 
            array (
                'id' => 121,
                'user_id' => 1,
                'koi_id' => 'RG2410002B',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-05-20 17:12:57',
                'updated_at' => '2025-05-20 17:12:57',
            ),
            25 => 
            array (
                'id' => 122,
                'user_id' => 2,
                'koi_id' => 'RG2411001A',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-05-20 17:24:32',
                'updated_at' => '2025-05-20 17:24:32',
            ),
            26 => 
            array (
                'id' => 123,
                'user_id' => 2,
                'koi_id' => 'RG2409009E',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-05-23 11:54:17',
                'updated_at' => '2025-05-23 11:54:17',
            ),
            27 => 
            array (
                'id' => 124,
                'user_id' => 1,
                'koi_id' => 'RG2410003D',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-06-05 10:38:41',
                'updated_at' => '2025-06-05 10:38:41',
            ),
            28 => 
            array (
                'id' => 125,
                'user_id' => 1,
                'koi_id' => 'RG2409011B',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-06-05 10:38:48',
                'updated_at' => '2025-06-05 10:38:48',
            ),
            29 => 
            array (
                'id' => 126,
                'user_id' => 5,
                'koi_id' => 'RG2409011B',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-06-05 10:39:23',
                'updated_at' => '2025-06-05 10:39:23',
            ),
            30 => 
            array (
                'id' => 127,
                'user_id' => 1,
                'koi_id' => 'RG2409009D',
                'activity_type' => 'view',
                'weight' => '1.00',
                'created_at' => '2025-06-15 17:02:17',
                'updated_at' => '2025-06-15 17:02:17',
            ),
            31 => 
            array (
                'id' => 128,
                'user_id' => 3,
                'koi_id' => 'RG2411001B',
                'activity_type' => 'like',
                'weight' => '2.00',
                'created_at' => '2025-07-26 15:05:13',
                'updated_at' => '2025-07-26 15:05:13',
            ),
            32 => 
            array (
                'id' => 130,
                'user_id' => 3,
                'koi_id' => 'RG2411001A',
                'activity_type' => 'like',
                'weight' => '2.00',
                'created_at' => '2025-07-26 15:27:24',
                'updated_at' => '2025-07-26 15:27:24',
            ),
        ));
        
        
    }
}