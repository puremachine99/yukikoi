<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NopelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Nopel',
            'profile_photo' => 'profile_photos/glCkscuoSM9iSUM3x57ewjXklT1pGz9ySilLQ4yd.jpg',
            'email' => 'puremachine99@gmail.com',
            'farm_name' => 'Jinhsi Koi Farm',
            'address' => 'Jl. Besi no.1 Kav 1',
            'phone_number' => '082257111684',
            'password' => bcrypt('qQ123123'),
            'city' => 'malang',
            'nik' => '3573012511940005',
            'is_seller' => '1',
            'remember_token' => '2lijKQ5LqbcAwsXFjfsODUTvecFSnjqouL2NqgpaHmLl8LVDibnczrG38w0b',
            'created_at' => 'NOW()',
            'updated_at' => 'NOW()',
        ]);
    }
}
