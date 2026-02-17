<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'puremachine99@gmail.com';
        $user = User::where('email', $email)->first();

        if (! $user) {
            $this->command?->warn("User dengan email {$email} tidak ditemukan. Jalankan UserSeeder terlebih dahulu.");
            return;
        }

        $speciesIds = DB::table('fish_species')->pluck('id')->all();

        $items = [];
        for ($i = 1; $i <= 5; $i++) {
            $items[] = [
                'sku'          => "SEED-PUREMACHINE-{$i}",
                'owner_id'     => $user->id,
                'species_id'   => $speciesIds ? $speciesIds[array_rand($speciesIds)] : null,
                'title'        => "Koi Demo {$i}",
                'description'  => 'Item demo hasil seeder untuk keperluan testing.',
                'gender'       => ['male', 'female', 'unknown'][$i % 3],
                'size_cm'      => 20 + $i * 2,
                'open_bid'     => 100000 + $i * 50000,
                'bid_step'     => 10000,
                'buy_now_price'=> 600000 + $i * 100000,
                'media'        => [
                    "https://picsum.photos/seed/koi{$i}/800/600",
                ],
                'status'       => 'active',
            ];
        }

        foreach ($items as $data) {
            // Pastikan id tetap baru setiap seeding, gunakan SKU sebagai kunci unik
            Item::updateOrCreate(
                ['sku' => $data['sku']],
                $data
            );
        }
    }
}

