<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ChatsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('chats')->delete();
        
        \DB::table('chats')->insert(array (
            0 => 
            array (
                'id' => 298,
                'user_id' => 1,
                'koi_id' => 'RG2410002C',
                'message' => 'he',
                'created_at' => '2025-03-13 19:49:08',
                'updated_at' => '2025-03-13 19:49:08',
            ),
            1 => 
            array (
                'id' => 299,
                'user_id' => 1,
                'koi_id' => 'RG2409011C',
                'message' => 'halo',
                'created_at' => '2025-03-22 21:19:49',
                'updated_at' => '2025-03-22 21:19:49',
            ),
            2 => 
            array (
                'id' => 300,
                'user_id' => 1,
                'koi_id' => 'RG2409011C',
                'message' => 'p',
                'created_at' => '2025-03-22 21:20:17',
                'updated_at' => '2025-03-22 21:20:17',
            ),
            3 => 
            array (
                'id' => 301,
                'user_id' => 1,
                'koi_id' => 'RG2409011C',
                'message' => 'test',
                'created_at' => '2025-03-22 21:20:32',
                'updated_at' => '2025-03-22 21:20:32',
            ),
            4 => 
            array (
                'id' => 302,
                'user_id' => 5,
                'koi_id' => 'RG2409011C',
                'message' => 'oi',
                'created_at' => '2025-03-22 21:20:38',
                'updated_at' => '2025-03-22 21:20:38',
            ),
            5 => 
            array (
                'id' => 303,
                'user_id' => 1,
                'koi_id' => 'RG2411001A',
                'message' => 'halo',
                'created_at' => '2025-05-20 12:48:50',
                'updated_at' => '2025-05-20 12:48:50',
            ),
            6 => 
            array (
                'id' => 304,
                'user_id' => 2,
                'koi_id' => 'RG2411001A',
                'message' => 'halo',
                'created_at' => '2025-05-20 17:24:37',
                'updated_at' => '2025-05-20 17:24:37',
            ),
            7 => 
            array (
                'id' => 305,
                'user_id' => 2,
                'koi_id' => 'RG2411001A',
                'message' => 'up dong ?',
                'created_at' => '2025-05-20 17:24:57',
                'updated_at' => '2025-05-20 17:24:57',
            ),
            8 => 
            array (
                'id' => 306,
                'user_id' => 1,
                'koi_id' => 'RG2411001A',
                'message' => 'halo',
                'created_at' => '2025-05-20 17:25:16',
                'updated_at' => '2025-05-20 17:25:16',
            ),
            9 => 
            array (
                'id' => 307,
                'user_id' => 2,
                'koi_id' => 'RG2411001A',
                'message' => 'p',
                'created_at' => '2025-05-20 17:25:19',
                'updated_at' => '2025-05-20 17:25:19',
            ),
            10 => 
            array (
                'id' => 308,
                'user_id' => 1,
                'koi_id' => 'RG2411001A',
                'message' => 'gg',
                'created_at' => '2025-05-20 17:25:22',
                'updated_at' => '2025-05-20 17:25:22',
            ),
            11 => 
            array (
                'id' => 309,
                'user_id' => 1,
                'koi_id' => 'RG2411001A',
                'message' => 'hehe',
                'created_at' => '2025-05-20 17:29:15',
                'updated_at' => '2025-05-20 17:29:15',
            ),
            12 => 
            array (
                'id' => 310,
                'user_id' => 2,
                'koi_id' => 'RG2411001A',
                'message' => 'hehe',
                'created_at' => '2025-05-20 17:30:00',
                'updated_at' => '2025-05-20 17:30:00',
            ),
            13 => 
            array (
                'id' => 311,
                'user_id' => 1,
                'koi_id' => 'RG2411001A',
                'message' => 'test',
                'created_at' => '2025-05-23 11:48:58',
                'updated_at' => '2025-05-23 11:48:58',
            ),
            14 => 
            array (
                'id' => 312,
                'user_id' => 1,
                'koi_id' => 'RG2411001A',
                'message' => 'test',
                'created_at' => '2025-05-23 11:48:58',
                'updated_at' => '2025-05-23 11:48:58',
            ),
            15 => 
            array (
                'id' => 313,
                'user_id' => 2,
                'koi_id' => 'RG2411001A',
                'message' => 'test',
                'created_at' => '2025-05-23 11:49:39',
                'updated_at' => '2025-05-23 11:49:39',
            ),
            16 => 
            array (
                'id' => 314,
                'user_id' => 2,
                'koi_id' => 'RG2409009E',
                'message' => 'p',
                'created_at' => '2025-05-23 12:06:45',
                'updated_at' => '2025-05-23 12:06:45',
            ),
            17 => 
            array (
                'id' => 315,
                'user_id' => 1,
                'koi_id' => 'RG2409011B',
                'message' => 'halo',
                'created_at' => '2025-06-05 10:38:51',
                'updated_at' => '2025-06-05 10:38:51',
            ),
            18 => 
            array (
                'id' => 316,
                'user_id' => 1,
                'koi_id' => 'RG2410002A',
                'message' => 'he',
                'created_at' => '2025-06-15 17:01:47',
                'updated_at' => '2025-06-15 17:01:47',
            ),
            19 => 
            array (
                'id' => 317,
                'user_id' => 1,
                'koi_id' => 'RG2409009D',
                'message' => 'p',
                'created_at' => '2025-06-15 17:02:20',
                'updated_at' => '2025-06-15 17:02:20',
            ),
            20 => 
            array (
                'id' => 318,
                'user_id' => 1,
                'koi_id' => 'RG2409009D',
                'message' => 'pp',
                'created_at' => '2025-06-15 17:02:20',
                'updated_at' => '2025-06-15 17:02:20',
            ),
            21 => 
            array (
                'id' => 319,
                'user_id' => 1,
                'koi_id' => 'RG2409009D',
                'message' => 'ppp',
                'created_at' => '2025-06-15 17:02:21',
                'updated_at' => '2025-06-15 17:02:21',
            ),
            22 => 
            array (
                'id' => 320,
                'user_id' => 1,
                'koi_id' => 'RG2409009D',
                'message' => 'pppp',
                'created_at' => '2025-06-15 17:02:21',
                'updated_at' => '2025-06-15 17:02:21',
            ),
            23 => 
            array (
                'id' => 321,
                'user_id' => 1,
                'koi_id' => 'RG2410003C',
                'message' => 'helo',
                'created_at' => '2025-07-17 15:03:17',
                'updated_at' => '2025-07-17 15:03:17',
            ),
        ));
        
        
    }
}