<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FollowsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('follows')->delete();
        
        \DB::table('follows')->insert(array (
            0 => 
            array (
                'id' => 1,
                'follower_id' => 1,
                'following_id' => 3,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'follower_id' => 1,
                'following_id' => 4,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 5,
                'follower_id' => 1,
                'following_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 8,
                'follower_id' => 2,
                'following_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 9,
                'follower_id' => 5,
                'following_id' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 10,
                'follower_id' => 1,
                'following_id' => 5,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 11,
                'follower_id' => 5,
                'following_id' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}