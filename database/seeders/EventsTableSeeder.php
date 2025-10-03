<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('events')->delete();
        
        \DB::table('events')->insert(array (
            0 => 
            array (
                'id' => 7,
                'event_name' => 'Lelang Event 1 - Part 1',
                'description' => 'deskripsi dan rules dari event ini',
                'banner' => 'banners/NxVlItP7aIztFewtDNwpmILezUbmDFzSvh5TFlK1.png',
                'event_type' => 'azukari',
                'reward_mode' => 'percent',
                'reward_data' => '[{"nomination": "Juara 1", "reward_percentage": "5"}, {"nomination": "Juara 2", "reward_percentage": "3"}, {"nomination": "Juara 3", "reward_percentage": "2"}, {"nomination": "runner up", "reward_percentage": "1"}]',
                'total_reward' => 15,
                'fixed_reward_total' => 5000000,
                'submission_time' => '2025-06-10 07:00:00',
                'judging_time' => '2024-12-13 11:22:00',
                'start_time' => '2024-12-17 07:00:00',
                'end_time' => '2024-12-17 19:00:00',
                'event_code' => 'AZUKARI2412001-1',
                'created_by' => 1,
                'approval_code' => NULL,
                'approved_by' => NULL,
                'approved_at' => NULL,
                'status' => 'pending',
            'doorprize' => 'Merchendise( topi, payung, kaos) , vitamin, pakan ikan / pelet',
                'created_at' => '2024-12-10 01:54:21',
                'updated_at' => '2024-12-10 01:54:21',
            ),
            1 => 
            array (
                'id' => 8,
                'event_name' => 'Lelang Event 1 - Part 2',
                'description' => 'deskripsi dan rules dari event ini',
                'banner' => 'banners/NxVlItP7aIztFewtDNwpmILezUbmDFzSvh5TFlK1.png',
                'event_type' => 'azukari',
                'reward_mode' => 'percent',
                'reward_data' => '[{"nomination": "Juara 1", "reward_percentage": "5"}, {"nomination": "Juara 2", "reward_percentage": "3"}, {"nomination": "Juara 3", "reward_percentage": "2"}, {"nomination": "runner up", "reward_percentage": "1"}]',
                'total_reward' => 15,
                'fixed_reward_total' => 5000000,
                'submission_time' => '2025-06-10 07:00:00',
                'judging_time' => '2024-12-13 11:22:00',
                'start_time' => '2024-12-18 07:00:00',
                'end_time' => '2024-12-18 19:00:00',
                'event_code' => 'AZUKARI2412001-2',
                'created_by' => 1,
                'approval_code' => NULL,
                'approved_by' => NULL,
                'approved_at' => NULL,
                'status' => 'pending',
            'doorprize' => 'Merchendise( topi, payung, kaos) , vitamin, pakan ikan / pelet',
                'created_at' => '2024-12-10 01:54:21',
                'updated_at' => '2024-12-10 01:54:21',
            ),
            2 => 
            array (
                'id' => 9,
                'event_name' => 'Lelang Event 2 - Part 1',
                'description' => 'deskripsi dan rules dari event ini',
                'banner' => 'banners/0mNXOD3sR0KIMTxEtSp4AyfMFjyu556JilsCTlHA.png',
                'event_type' => 'azukari',
                'reward_mode' => 'percent',
                'reward_data' => '[{"nomination": "Juara 1", "reward_percentage": "15"}]',
                'total_reward' => 15,
                'fixed_reward_total' => 5000000,
                'submission_time' => '2025-06-10 07:00:00',
                'judging_time' => '2024-12-13 11:22:00',
                'start_time' => '2024-12-17 07:00:00',
                'end_time' => '2024-12-17 19:00:00',
                'event_code' => 'AZUKARI2412003-1',
                'created_by' => 1,
                'approval_code' => NULL,
                'approved_by' => NULL,
                'approved_at' => NULL,
                'status' => 'pending',
            'doorprize' => 'Merchendise( topi, payung, kaos) , vitamin, pakan ikan / pelet',
                'created_at' => '2024-12-10 01:56:23',
                'updated_at' => '2024-12-10 01:56:23',
            ),
            3 => 
            array (
                'id' => 10,
                'event_name' => 'Lelang Event 2 - Part 2',
                'description' => 'deskripsi dan rules dari event ini',
                'banner' => 'banners/0mNXOD3sR0KIMTxEtSp4AyfMFjyu556JilsCTlHA.png',
                'event_type' => 'azukari',
                'reward_mode' => 'percent',
                'reward_data' => '[{"nomination": "Juara 1", "reward_percentage": "15"}]',
                'total_reward' => 15,
                'fixed_reward_total' => 5000000,
                'submission_time' => '2025-06-10 07:00:00',
                'judging_time' => '2024-12-13 11:22:00',
                'start_time' => '2024-12-18 01:56:00',
                'end_time' => '2024-12-19 01:56:00',
                'event_code' => 'AZUKARI2412003-2',
                'created_by' => 1,
                'approval_code' => NULL,
                'approved_by' => NULL,
                'approved_at' => NULL,
                'status' => 'pending',
            'doorprize' => 'Merchendise( topi, payung, kaos) , vitamin, pakan ikan / pelet',
                'created_at' => '2024-12-10 01:56:23',
                'updated_at' => '2024-12-10 01:56:23',
            ),
            4 => 
            array (
                'id' => 11,
                'event_name' => 'Lelang Event 2 - Part 3',
                'description' => 'deskripsi dan rules dari event ini',
                'banner' => 'banners/0mNXOD3sR0KIMTxEtSp4AyfMFjyu556JilsCTlHA.png',
                'event_type' => 'azukari',
                'reward_mode' => 'percent',
                'reward_data' => '[{"nomination": "Juara 1", "reward_percentage": "15"}]',
                'total_reward' => 15,
                'fixed_reward_total' => 5000000,
                'submission_time' => '2025-06-10 07:00:00',
                'judging_time' => '2024-12-13 11:22:00',
                'start_time' => '2024-12-20 01:56:00',
                'end_time' => '2024-12-21 01:56:00',
                'event_code' => 'AZUKARI2412003-3',
                'created_by' => 1,
                'approval_code' => NULL,
                'approved_by' => NULL,
                'approved_at' => NULL,
                'status' => 'pending',
            'doorprize' => 'Merchendise( topi, payung, kaos) , vitamin, pakan ikan / pelet',
                'created_at' => '2024-12-10 01:56:23',
                'updated_at' => '2024-12-10 01:56:23',
            ),
        ));
        
        
    }
}