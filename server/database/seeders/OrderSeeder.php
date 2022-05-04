<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
//use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert(
            [
                [
                    'cus_name'=> 'Hakmana Kanakeratne',
                    'order_total'=> 90000.00,
                    'order_status'=> 'Waiting for payment',
                    'shipping_status'=> 'Awaiting',
                    'tracking_num'=> '33XJN370050801000931504',
                    'order_date'=> '29 AUG 2021',
                    'order_time'=> '04:36 PM',
                ],[
                    'cus_name'=> 'John Doe',
                    'order_total'=> 80000.00,
                    'order_status'=> 'Waiting for payment',
                    'shipping_status'=> 'Awaiting',
                    'tracking_num'=> '33XJN370050801000931504',
                    'order_date'=> '29 AUG 2021',
                    'order_time'=> '04:36 PM',
                ],[
                    'cus_name'=> 'Adam Scott',
                    'order_total'=> 70000.00,
                    'order_status'=> 'Waiting for payment',
                    'shipping_status'=> 'Awaiting',
                    'tracking_num'=> '33XJN370050801000931504',
                    'order_date'=> '29 AUG 2021',
                    'order_time'=> '04:36 PM',
                    ]         
            ]);

    }
}
