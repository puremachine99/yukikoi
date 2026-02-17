<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FishSpeciesSeeder extends Seeder
{
    public function run(): void
    {
        $species = [
            [
                'id' => Str::uuid(),
                'name' => 'Kohaku',
                'description' => 'Koi klasik dengan dasar putih bersih (shiroji) dan pola merah terang (hi) di atas tubuh. Biasanya pola merahnya tajam dan simetris, sangat dihargai di kontes.',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Sanke (Taisho Sanke)',
                'description' => 'Dasar putih dengan kombinasi pola merah (hi) dan bercak hitam (sumi). Bedanya dengan Showa, Sanke tidak memiliki sumi di kepala.',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Showa (Showa Sanshoku)',
                'description' => 'Tubuh dasar hitam dengan pola merah dan putih. Ciri khasnya adalah adanya sumi (hitam) yang muncul sampai ke kepala, memberikan kontras kuat.',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Shiro Utsuri',
                'description' => 'Koi dengan tubuh dasar putih dan bercak hitam tegas. Kontras hitam-putihnya menjadi daya tarik utama, terlihat elegan dan sederhana.',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Asagi',
                'description' => 'Koi dengan sisik biru-keabu-abuan teratur di punggung, bagian perut, pipi, dan sirip biasanya merah-oranye. Memberikan tampilan klasik dan tenang.',
            ],
        ];

        DB::table('fish_species')->insert($species);
    }
}
