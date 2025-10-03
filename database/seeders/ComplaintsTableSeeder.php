<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ComplaintsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('complaints')->delete();
        
        
        
    }
}