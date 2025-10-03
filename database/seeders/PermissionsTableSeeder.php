<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'view_role',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:00:01',
                'updated_at' => '2025-06-26 10:00:01',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'view_any_role',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:00:01',
                'updated_at' => '2025-06-26 10:00:01',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'create_role',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:00:01',
                'updated_at' => '2025-06-26 10:00:01',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'update_role',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:00:01',
                'updated_at' => '2025-06-26 10:00:01',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'delete_role',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:00:01',
                'updated_at' => '2025-06-26 10:00:01',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'delete_any_role',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:00:01',
                'updated_at' => '2025-06-26 10:00:01',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'view_user',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:05:42',
                'updated_at' => '2025-06-26 10:05:42',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'view_any_user',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:05:42',
                'updated_at' => '2025-06-26 10:05:42',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'create_user',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:05:42',
                'updated_at' => '2025-06-26 10:05:42',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'update_user',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:05:42',
                'updated_at' => '2025-06-26 10:05:42',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'restore_user',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:05:42',
                'updated_at' => '2025-06-26 10:05:42',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'restore_any_user',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:05:43',
                'updated_at' => '2025-06-26 10:05:43',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'replicate_user',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:05:43',
                'updated_at' => '2025-06-26 10:05:43',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'reorder_user',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:05:43',
                'updated_at' => '2025-06-26 10:05:43',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'delete_user',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:05:43',
                'updated_at' => '2025-06-26 10:05:43',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'delete_any_user',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:05:43',
                'updated_at' => '2025-06-26 10:05:43',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'force_delete_user',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:05:43',
                'updated_at' => '2025-06-26 10:05:43',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'force_delete_any_user',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:05:43',
                'updated_at' => '2025-06-26 10:05:43',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'view_auction',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:58:37',
                'updated_at' => '2025-06-26 10:58:37',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'view_any_auction',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:58:37',
                'updated_at' => '2025-06-26 10:58:37',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'create_auction',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:58:37',
                'updated_at' => '2025-06-26 10:58:37',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'update_auction',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:58:37',
                'updated_at' => '2025-06-26 10:58:37',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'restore_auction',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:58:37',
                'updated_at' => '2025-06-26 10:58:37',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'restore_any_auction',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:58:37',
                'updated_at' => '2025-06-26 10:58:37',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'replicate_auction',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:58:37',
                'updated_at' => '2025-06-26 10:58:37',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'reorder_auction',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:58:37',
                'updated_at' => '2025-06-26 10:58:37',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'delete_auction',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:58:37',
                'updated_at' => '2025-06-26 10:58:37',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'delete_any_auction',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:58:37',
                'updated_at' => '2025-06-26 10:58:37',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'force_delete_auction',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:58:37',
                'updated_at' => '2025-06-26 10:58:37',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'force_delete_any_auction',
                'guard_name' => 'web',
                'created_at' => '2025-06-26 10:58:37',
                'updated_at' => '2025-06-26 10:58:37',
            ),
        ));
        
        
    }
}