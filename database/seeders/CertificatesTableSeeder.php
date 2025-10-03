<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CertificatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('certificates')->delete();
        
        \DB::table('certificates')->insert(array (
            0 => 
            array (
                'id' => 8,
                'koi_id' => 'RG2409009A',
                'url_gambar' => 'koi_certificates/2EAQq2nOkNlps3QgHkZXOL4VyjzpQ1EdS7V3NjPd.jpg',
                'created_at' => '2024-09-15 12:04:43',
                'updated_at' => '2024-09-15 12:04:43',
            ),
            1 => 
            array (
                'id' => 9,
                'koi_id' => 'RG2409009B',
                'url_gambar' => 'koi_certificates/RBDPitOqKLlCedqj5gN0e2aC6QEQOSVCN7UCJwKQ.jpg',
                'created_at' => '2024-09-15 12:04:44',
                'updated_at' => '2024-09-15 12:04:44',
            ),
            2 => 
            array (
                'id' => 10,
                'koi_id' => 'RG2409009C',
                'url_gambar' => 'koi_certificates/HXXa40OplPQLGGfpHzRTKcnJERp32fHEg0iPlvda.jpg',
                'created_at' => '2024-09-15 12:04:44',
                'updated_at' => '2024-09-15 12:04:44',
            ),
            3 => 
            array (
                'id' => 11,
                'koi_id' => 'RG2409009D',
                'url_gambar' => 'koi_certificates/6glXEuzliRutRSW99Dkn0bbx0yp4CkHSXsStM1eS.jpg',
                'created_at' => '2024-09-15 12:04:44',
                'updated_at' => '2024-09-15 12:04:44',
            ),
            4 => 
            array (
                'id' => 12,
                'koi_id' => 'RG2409009E',
                'url_gambar' => 'koi_certificates/uJTE82iNFb62w54oVAIOXzeJZCeMgYYLUf4hJCWJ.jpg',
                'created_at' => '2024-09-15 12:04:44',
                'updated_at' => '2024-09-15 12:04:44',
            ),
            5 => 
            array (
                'id' => 13,
                'koi_id' => 'RG2409011A',
                'url_gambar' => 'koi_certificates/IG0B6DEJazhaeLtAugktI7nrxHIwzkDdBpLvfmVr.jpg',
                'created_at' => '2024-09-24 10:30:17',
                'updated_at' => '2024-09-24 10:30:17',
            ),
            6 => 
            array (
                'id' => 14,
                'koi_id' => 'RG2409011B',
                'url_gambar' => 'koi_certificates/IK94fVE5gr7536sDDgcLKAlj92r34RduF2Ezw3gj.jpg',
                'created_at' => '2024-09-24 10:30:17',
                'updated_at' => '2024-09-24 10:30:17',
            ),
            7 => 
            array (
                'id' => 15,
                'koi_id' => 'RG2409011C',
                'url_gambar' => 'koi_certificates/nS99KIhXrwG0AZZlCJ5hAPROjz9XRTBxz3NWTMvL.jpg',
                'created_at' => '2024-09-24 10:30:17',
                'updated_at' => '2024-09-24 10:30:17',
            ),
            8 => 
            array (
                'id' => 16,
                'koi_id' => 'RG2409011D',
                'url_gambar' => 'koi_certificates/4yJSAGymwZajzlFc84Wbc18DlUYaADLbB1pzn1aO.jpg',
                'created_at' => '2024-09-24 10:30:17',
                'updated_at' => '2024-09-24 10:30:17',
            ),
            9 => 
            array (
                'id' => 17,
                'koi_id' => 'RG2410003C',
                'url_gambar' => 'koi_certificates/tdzQBxOgBlnjq9CYJ09JZYPzPG0L4XhQ6Uq7WG31.jpg',
                'created_at' => '2024-12-11 18:51:33',
                'updated_at' => '2024-12-11 18:51:33',
            ),
            10 => 
            array (
                'id' => 18,
                'koi_id' => 'RG2410003C',
                'url_gambar' => 'koi_certificates/exm7F5nfmJT9y5uuCqPmbFLMZmhVJx1c6j6fxb2j.jpg',
                'created_at' => '2024-12-11 18:51:33',
                'updated_at' => '2024-12-11 18:51:33',
            ),
            11 => 
            array (
                'id' => 19,
                'koi_id' => 'RG2410003C',
                'url_gambar' => 'koi_certificates/1BPrVYtjR45B5AtvwCt6R2tLowYyZqNUldv1lLw2.jpg',
                'created_at' => '2024-12-11 18:51:33',
                'updated_at' => '2024-12-11 18:51:33',
            ),
        ));
        
        
    }
}