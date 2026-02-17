<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Admin YukiAuction',
                'email'    => 'admin@yukiauction.test',
                'password' => Hash::make('12345678'),
                'phone_e164' => '6282257111683', // opsional, kalau sudah ada kolom ini
            ],
            [
                'name'     => 'Noval Luqmana Annurussyah',
                'email'    => 'puremachine99@gmail.com',
                'password' => Hash::make('12345678'),
                'phone_e164' => '6282257111684',
            ],
            [
                'name'     => 'Buyer Demo',
                'email'    => 'buyer@yukiauction.test',
                'password' => Hash::make('12345678'),
                'phone_e164' => '62812257111685',
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']], // cek unik by email
                $data
            );
        }
    }
}
