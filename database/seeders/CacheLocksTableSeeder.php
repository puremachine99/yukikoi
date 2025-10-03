<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CacheLocksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cache_locks')->delete();
        
        
        
    }
}