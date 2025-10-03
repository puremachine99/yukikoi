<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JobBatchesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('job_batches')->delete();
        
        
        
    }
}