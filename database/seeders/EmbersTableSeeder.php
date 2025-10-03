<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmbersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('embers')->delete();
        
        \DB::table('embers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'koi_id' => 'RG2409011A',
                'user_id' => 1,
                'created_at' => '2024-09-30 18:53:22',
                'updated_at' => '2024-09-30 18:53:22',
            ),
        ));
        
        
    }
}