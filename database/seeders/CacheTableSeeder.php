<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CacheTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('cache')->delete();
        
        \DB::table('cache')->insert(array (
            0 => 
            array (
                'key' => '0822571111684|127.0.0.1',
                'value' => 'i:2;',
                'expiration' => 1753508316,
            ),
            1 => 
            array (
                'key' => '0822571111684|127.0.0.1:timer',
                'value' => 'i:1753508316;',
                'expiration' => 1753508316,
            ),
            2 => 
            array (
                'key' => '6282257111684|127.0.0.1',
                'value' => 'i:1;',
                'expiration' => 1748783436,
            ),
            3 => 
            array (
                'key' => '6282257111684|127.0.0.1:timer',
                'value' => 'i:1748783436;',
                'expiration' => 1748783436,
            ),
            4 => 
            array (
                'key' => 'bid-action:1',
                'value' => 'i:1;',
                'expiration' => 1749981824,
            ),
            5 => 
            array (
                'key' => 'bid-action:1:timer',
                'value' => 'i:1749981824;',
                'expiration' => 1749981824,
            ),
            6 => 
            array (
                'key' => 'bid-action:2',
                'value' => 'i:2;',
                'expiration' => 1747976127,
            ),
            7 => 
            array (
                'key' => 'bid-action:2:timer',
                'value' => 'i:1747976127;',
                'expiration' => 1747976127,
            ),
            8 => 
            array (
                'key' => 'chat-action:1',
                'value' => 'i:1;',
                'expiration' => 1752739457,
            ),
            9 => 
            array (
                'key' => 'chat-action:1:timer',
                'value' => 'i:1752739457;',
                'expiration' => 1752739457,
            ),
            10 => 
            array (
                'key' => 'chat-action:2',
                'value' => 'i:1;',
                'expiration' => 1747976865,
            ),
            11 => 
            array (
                'key' => 'chat-action:2:timer',
                'value' => 'i:1747976865;',
                'expiration' => 1747976865,
            ),
            12 => 
            array (
                'key' => 'livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3',
                'value' => 'i:1;',
                'expiration' => 1752481859,
            ),
            13 => 
            array (
                'key' => 'livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3:timer',
                'value' => 'i:1752481859;',
                'expiration' => 1752481859,
            ),
            14 => 
            array (
                'key' => 'spatie.permission.cache',
                'value' => 'a:3:{s:5:"alias";a:4:{s:1:"a";s:2:"id";s:1:"b";s:4:"name";s:1:"c";s:10:"guard_name";s:1:"r";s:5:"roles";}s:11:"permissions";a:30:{i:0;a:4:{s:1:"a";i:1;s:1:"b";s:9:"view_role";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:1;a:4:{s:1:"a";i:2;s:1:"b";s:13:"view_any_role";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:2;a:4:{s:1:"a";i:3;s:1:"b";s:11:"create_role";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:3;a:4:{s:1:"a";i:4;s:1:"b";s:11:"update_role";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:4;a:4:{s:1:"a";i:5;s:1:"b";s:11:"delete_role";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:5;a:4:{s:1:"a";i:6;s:1:"b";s:15:"delete_any_role";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:6;a:4:{s:1:"a";i:7;s:1:"b";s:9:"view_user";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:7;a:4:{s:1:"a";i:8;s:1:"b";s:13:"view_any_user";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:8;a:4:{s:1:"a";i:9;s:1:"b";s:11:"create_user";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:9;a:4:{s:1:"a";i:10;s:1:"b";s:11:"update_user";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:10;a:4:{s:1:"a";i:11;s:1:"b";s:12:"restore_user";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:11;a:4:{s:1:"a";i:12;s:1:"b";s:16:"restore_any_user";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:12;a:4:{s:1:"a";i:13;s:1:"b";s:14:"replicate_user";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:13;a:4:{s:1:"a";i:14;s:1:"b";s:12:"reorder_user";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:14;a:4:{s:1:"a";i:15;s:1:"b";s:11:"delete_user";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:15;a:4:{s:1:"a";i:16;s:1:"b";s:15:"delete_any_user";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:16;a:4:{s:1:"a";i:17;s:1:"b";s:17:"force_delete_user";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:17;a:4:{s:1:"a";i:18;s:1:"b";s:21:"force_delete_any_user";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:18;a:4:{s:1:"a";i:19;s:1:"b";s:12:"view_auction";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:19;a:4:{s:1:"a";i:20;s:1:"b";s:16:"view_any_auction";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:20;a:4:{s:1:"a";i:21;s:1:"b";s:14:"create_auction";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:21;a:4:{s:1:"a";i:22;s:1:"b";s:14:"update_auction";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:22;a:4:{s:1:"a";i:23;s:1:"b";s:15:"restore_auction";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:23;a:4:{s:1:"a";i:24;s:1:"b";s:19:"restore_any_auction";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:24;a:4:{s:1:"a";i:25;s:1:"b";s:17:"replicate_auction";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:25;a:4:{s:1:"a";i:26;s:1:"b";s:15:"reorder_auction";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:26;a:4:{s:1:"a";i:27;s:1:"b";s:14:"delete_auction";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:27;a:4:{s:1:"a";i:28;s:1:"b";s:18:"delete_any_auction";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:28;a:4:{s:1:"a";i:29;s:1:"b";s:20:"force_delete_auction";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}i:29;a:4:{s:1:"a";i:30;s:1:"b";s:24:"force_delete_any_auction";s:1:"c";s:3:"web";s:1:"r";a:1:{i:0;i:1;}}}s:5:"roles";a:1:{i:0;a:3:{s:1:"a";i:1;s:1:"b";s:11:"super_admin";s:1:"c";s:3:"web";}}}',
                'expiration' => 1752806655,
            ),
            15 => 
            array (
                'key' => 'user-bids:1',
                'value' => 'i:1;',
                'expiration' => 1753516859,
            ),
            16 => 
            array (
                'key' => 'user-bids:1:timer',
                'value' => 'i:1753516859;',
                'expiration' => 1753516859,
            ),
            17 => 
            array (
                'key' => 'user-bids:3',
                'value' => 'i:1;',
                'expiration' => 1753517177,
            ),
            18 => 
            array (
                'key' => 'user-bids:3:timer',
                'value' => 'i:1753517177;',
                'expiration' => 1753517177,
            ),
        ));
        
        
    }
}