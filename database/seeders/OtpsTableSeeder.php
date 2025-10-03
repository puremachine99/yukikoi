<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OtpsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('otps')->delete();
        
        
        
    }
}