<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('transactions')->delete();
        
        \DB::table('transactions')->insert(array (
            0 => 
            array (
                'id' => 35,
                'user_id' => 5,
                'total_amount' => '10000000.00',
                'fee_payment_gateway' => '2500.00',
                'fee_application' => '1000.00',
                'fee_rekber' => '6500.00',
                'fee_shipping' => '150000.00',
                'total_with_fees' => '10160000.00',
                'status' => 'pending',
                'created_at' => '2025-03-13 18:01:07',
                'updated_at' => '2025-03-13 18:01:07',
                'external_id' => '39098c03-d39c-447d-bcd6-6b144a02eeff',
                'checkout_link' => 'https://checkout-staging.xendit.co/web/67d2baf2f594f9679aec8961',
            ),
            1 => 
            array (
                'id' => 36,
                'user_id' => 5,
                'total_amount' => '10000000.00',
                'fee_payment_gateway' => '2500.00',
                'fee_application' => '1000.00',
                'fee_rekber' => '15000.00',
                'fee_shipping' => '250000.00',
                'total_with_fees' => '10268500.00',
                'status' => 'pending',
                'created_at' => '2025-03-19 21:17:53',
                'updated_at' => '2025-03-19 21:17:53',
                'external_id' => '22a2846d-4e2c-4f09-bfcb-6fe97fe51c86',
                'checkout_link' => 'https://checkout-staging.xendit.co/web/67dad2128e9185b33db9f317',
            ),
            2 => 
            array (
                'id' => 37,
                'user_id' => 5,
                'total_amount' => '10000000.00',
                'fee_payment_gateway' => '2500.00',
                'fee_application' => '1000.00',
                'fee_rekber' => '6500.00',
                'fee_shipping' => '150000.00',
                'total_with_fees' => '10160000.00',
                'status' => 'pending',
                'created_at' => '2025-03-22 14:41:36',
                'updated_at' => '2025-03-22 14:41:36',
                'external_id' => '6ee6d8cb-a288-4150-bae2-69254cb70245',
                'checkout_link' => 'https://checkout-staging.xendit.co/web/67de69b1155d97ca38d12cac',
            ),
            3 => 
            array (
                'id' => 38,
                'user_id' => 1,
                'total_amount' => '10000000.00',
                'fee_payment_gateway' => '2500.00',
                'fee_application' => '1000.00',
                'fee_rekber' => '6500.00',
                'fee_shipping' => '99000.00',
                'total_with_fees' => '10109000.00',
                'status' => 'pending',
                'created_at' => '2025-05-26 15:49:01',
                'updated_at' => '2025-05-26 15:49:01',
                'external_id' => '57c3166f-d2f4-4324-bd6e-e67baa1b6545',
                'checkout_link' => 'https://checkout-staging.xendit.co/web/68342aff7e386de4cd752c76',
            ),
        ));
        
        
    }
}