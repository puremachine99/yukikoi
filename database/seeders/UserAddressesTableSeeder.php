<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserAddressesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_addresses')->delete();
        
        \DB::table('user_addresses')->insert(array (
            0 => 
            array (
                'id' => 2,
                'user_id' => 2,
                'recipient_name' => 'noval luqmana',
                'phone_number' => '082257111684',
                'full_address' => 'jl besi no 1 kav 1',
                'city' => 'malang',
                'district' => 'Blimbing',
                'type' => 'rumah',
                'is_default' => 1,
                'created_at' => '2024-11-19 11:54:32',
                'updated_at' => '2024-11-21 07:10:46',
            ),
            1 => 
            array (
                'id' => 5,
                'user_id' => 2,
                'recipient_name' => 'Firda Aulia',
                'phone_number' => '082257111685',
                'full_address' => 'jl ahmad yani no. 519',
                'city' => 'Malang',
                'district' => 'purwodadi',
                'type' => 'rumah',
                'is_default' => 0,
                'created_at' => '2024-11-19 13:20:59',
                'updated_at' => '2024-11-21 07:10:46',
            ),
            2 => 
            array (
                'id' => 6,
                'user_id' => 2,
                'recipient_name' => 'Alfan',
                'phone_number' => '082257111686',
                'full_address' => 'Jl. Candi sambiasri 128, juwangen, purwomartani, kalasan sleman, DIY via travel',
                'city' => 'Blitar',
                'district' => 'Blitar',
                'type' => 'kantor',
                'is_default' => 0,
                'created_at' => '2024-11-19 14:21:15',
                'updated_at' => '2024-11-21 07:10:46',
            ),
            3 => 
            array (
                'id' => 7,
                'user_id' => 5,
                'recipient_name' => 'Firda Aulia',
                'phone_number' => '082256111685',
                'full_address' => 'Jl A Yani 519, Purwodadi, RT 5/ RW 24',
                'city' => 'Malang',
                'district' => 'Blimbing',
                'type' => 'rumah',
                'is_default' => 1,
                'created_at' => '2024-11-21 14:10:00',
                'updated_at' => '2024-11-21 14:10:00',
            ),
            4 => 
            array (
                'id' => 8,
                'user_id' => 1,
                'recipient_name' => 'noval luqmana',
                'phone_number' => '082257111684',
                'full_address' => 'jl besi no 1 kav 1, RT 5, RW 24, Purwantoro, Blimbing',
                'city' => 'Malang',
                'district' => 'Blimbing',
                'type' => 'rumah',
                'is_default' => 1,
                'created_at' => '2025-01-17 15:04:15',
                'updated_at' => '2025-01-17 15:04:15',
            ),
        ));
        
        
    }
}