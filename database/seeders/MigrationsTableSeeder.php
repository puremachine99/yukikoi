<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MigrationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('migrations')->delete();
        
        \DB::table('migrations')->insert(array (
            0 => 
            array (
                'id' => 1,
                'migration' => '0001_01_01_000001_create_cache_table',
                'batch' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'migration' => '0001_01_01_000002_create_jobs_table',
                'batch' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'migration' => '2024_09_05_052913_create_users_table',
                'batch' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'migration' => '2024_09_05_052942_create_auctions_table',
                'batch' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'migration' => '2024_09_05_053000_create_kois_table',
                'batch' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'migration' => '2024_09_05_053017_create_certificates_table',
                'batch' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'migration' => '2024_09_05_053033_create_bids_table',
                'batch' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'migration' => '2024_09_05_054636_create_sessions_table',
                'batch' => 1,
            ),
            8 => 
            array (
                'id' => 9,
                'migration' => '2024_09_09_135613_create_media_table',
                'batch' => 1,
            ),
            9 => 
            array (
                'id' => 10,
                'migration' => '2024_09_09_140835_create_embers_table',
                'batch' => 1,
            ),
            10 => 
            array (
                'id' => 11,
                'migration' => '2024_09_25_135428_add_extra_time_table_to_auctions_table',
                'batch' => 1,
            ),
            11 => 
            array (
                'id' => 12,
                'migration' => '2024_09_26_061609_add_is_sniping_to_bids_table',
                'batch' => 1,
            ),
            12 => 
            array (
                'id' => 13,
                'migration' => '2024_09_27_085911_add_scrset_column_to_users_table',
                'batch' => 1,
            ),
            13 => 
            array (
                'id' => 14,
                'migration' => '2024_09_28_141501_create_chats_table',
                'batch' => 1,
            ),
            14 => 
            array (
                'id' => 15,
                'migration' => '2024_09_29_164556_add_is_bin_column_to_bid_table',
                'batch' => 1,
            ),
            15 => 
            array (
                'id' => 16,
                'migration' => '2024_10_12_141953_create_ads_table',
                'batch' => 1,
            ),
            16 => 
            array (
                'id' => 17,
                'migration' => '2024_10_13_124238_add_role_to_users_table',
                'batch' => 1,
            ),
            17 => 
            array (
                'id' => 18,
                'migration' => '2024_10_21_134950_create_follows_table',
                'batch' => 1,
            ),
            18 => 
            array (
                'id' => 19,
                'migration' => '2024_10_22_174641_add_priority_to_users_table',
                'batch' => 1,
            ),
            19 => 
            array (
                'id' => 20,
                'migration' => '2024_10_22_175106_create_subscribtions_table',
                'batch' => 1,
            ),
            20 => 
            array (
                'id' => 21,
                'migration' => '2024_10_22_200447_add_bio_to_users_table',
                'batch' => 1,
            ),
            21 => 
            array (
                'id' => 22,
                'migration' => '2024_10_26_160955_add_social_media_contacts_to_users_table',
                'batch' => 1,
            ),
            22 => 
            array (
                'id' => 23,
                'migration' => '2024_11_17_071126_create_transactions_table',
                'batch' => 1,
            ),
            23 => 
            array (
                'id' => 24,
                'migration' => '2024_11_17_152347_create_transaction_items_table',
                'batch' => 1,
            ),
            24 => 
            array (
                'id' => 25,
                'migration' => '2024_11_17_152416_create_seller_balances_table',
                'batch' => 1,
            ),
            25 => 
            array (
                'id' => 26,
                'migration' => '2024_11_17_161235_create_carts_table',
                'batch' => 1,
            ),
            26 => 
            array (
                'id' => 27,
                'migration' => '2024_11_19_070947_create_user_addresses_table',
                'batch' => 1,
            ),
            27 => 
            array (
                'id' => 28,
                'migration' => '2024_11_20_060444_add_external_id_and_checkout_link_to_transactions_table',
                'batch' => 1,
            ),
            28 => 
            array (
                'id' => 29,
                'migration' => '2024_11_21_033845_add_shipping_fee_to_transaction_items_table',
                'batch' => 1,
            ),
            29 => 
            array (
                'id' => 30,
                'migration' => '2024_11_21_035133_add_shipping_group_to_transaction_items_table',
                'batch' => 1,
            ),
            30 => 
            array (
                'id' => 31,
                'migration' => '2024_11_21_050111_add_farm_id_at_transaction_items_table',
                'batch' => 1,
            ),
            31 => 
            array (
                'id' => 32,
                'migration' => '2024_11_21_053231_add_is_processed_column_to_carts_table',
                'batch' => 1,
            ),
            32 => 
            array (
                'id' => 33,
                'migration' => '2024_11_21_070723_add_address_column_to_transaction_items_table',
                'batch' => 1,
            ),
            33 => 
            array (
                'id' => 34,
                'migration' => '2024_11_22_104448_create_likes_table',
                'batch' => 1,
            ),
            34 => 
            array (
                'id' => 35,
                'migration' => '2024_11_22_104500_create_lihats_table',
                'batch' => 1,
            ),
            35 => 
            array (
                'id' => 36,
                'migration' => '2024_12_01_183941_create_user_activities_table',
                'batch' => 1,
            ),
            36 => 
            array (
                'id' => 37,
                'migration' => '2024_12_04_130431_create_achievement_and_user_achievement_table',
                'batch' => 1,
            ),
            37 => 
            array (
                'id' => 38,
                'migration' => '2024_12_09_190500_create_events_table',
                'batch' => 1,
            ),
            38 => 
            array (
                'id' => 39,
                'migration' => '2024_12_10_005707_add_banner_column_to_events_table',
                'batch' => 1,
            ),
            39 => 
            array (
                'id' => 40,
                'migration' => '2025_01_22_101324_create_wishlists_table',
                'batch' => 2,
            ),
            40 => 
            array (
                'id' => 41,
                'migration' => '2025_02_15_162556_add_event_id_to_kois_table',
                'batch' => 3,
            ),
            41 => 
            array (
                'id' => 42,
                'migration' => '2025_02_26_045015_create_orders_table',
                'batch' => 4,
            ),
            42 => 
            array (
                'id' => 43,
                'migration' => '2025_02_27_171010_change_farm_column_type_in_transaction_items',
                'batch' => 5,
            ),
            43 => 
            array (
                'id' => 44,
                'migration' => '2025_02_27_174200_add_transaction_id_to_orders_table',
                'batch' => 6,
            ),
            44 => 
            array (
                'id' => 45,
                'migration' => '2025_02_27_212809_add_total_price_to_orders_table',
                'batch' => 7,
            ),
            45 => 
            array (
                'id' => 46,
                'migration' => '2025_02_27_213056_add_recipient_details_to_orders_table',
                'batch' => 8,
            ),
            46 => 
            array (
                'id' => 47,
                'migration' => '2025_02_28_125305_add_shipping_group_to_orders_table',
                'batch' => 9,
            ),
            47 => 
            array (
                'id' => 48,
                'migration' => '2025_03_01_122206_add_status_to_transaction_items',
                'batch' => 10,
            ),
            48 => 
            array (
                'id' => 53,
                'migration' => '2025_03_01_204027_create_ratings_table',
                'batch' => 11,
            ),
            49 => 
            array (
                'id' => 54,
                'migration' => '2025_03_02_140816_create_status_histories_table',
                'batch' => 11,
            ),
            50 => 
            array (
                'id' => 57,
                'migration' => '2025_03_04_151449_create_complaints_table',
                'batch' => 12,
            ),
            51 => 
            array (
                'id' => 61,
                'migration' => '2025_03_04_215759_add_status_enum_in_orders_table',
                'batch' => 13,
            ),
            52 => 
            array (
                'id' => 62,
                'migration' => '2025_03_05_123402_rename_columns_in_orders_and_transaction_items',
                'batch' => 14,
            ),
            53 => 
            array (
                'id' => 64,
                'migration' => '2025_03_05_165323_update_status_enum_in_orders_and_transaction_items',
                'batch' => 15,
            ),
            54 => 
            array (
                'id' => 65,
                'migration' => '2025_03_10_153554_add_karantina_and_cancel_reason_to_orders_and_transaction_items',
                'batch' => 16,
            ),
            55 => 
            array (
                'id' => 67,
                'migration' => '2025_03_10_154855_add_farm_owner_name_to_transaction_items',
                'batch' => 17,
            ),
            56 => 
            array (
                'id' => 68,
                'migration' => '2025_03_10_155958_drop_orders_table',
                'batch' => 18,
            ),
            57 => 
            array (
                'id' => 70,
                'migration' => '2025_03_10_172857_add_seller_id_to_transaction_items',
                'batch' => 19,
            ),
            58 => 
            array (
                'id' => 71,
                'migration' => '2025_03_10_185432_add_buyer_id_to_transaction_items',
                'batch' => 20,
            ),
            59 => 
            array (
                'id' => 72,
                'migration' => '2025_03_19_202905_update_status_enum_in_transaction_items',
                'batch' => 21,
            ),
            60 => 
            array (
                'id' => 73,
                'migration' => '2025_05_29_065438_create_password_reset_otps_table',
                'batch' => 22,
            ),
            61 => 
            array (
                'id' => 74,
                'migration' => '2025_06_01_111608_create_otps_table',
                'batch' => 23,
            ),
            62 => 
            array (
                'id' => 75,
                'migration' => '2025_06_19_142852_update_decimal_precision_to_support_10m',
                'batch' => 24,
            ),
            63 => 
            array (
                'id' => 76,
                'migration' => '2025_06_26_093452_create_permission_tables',
                'batch' => 25,
            ),
        ));
        
        
    }
}