<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service')->insert([
            [
                'id' => '1',
                'code'=> 'SRV-1808210001',
                'customer_id'=> '1',
                'customer_name'=> 'Azriel',
                'customer_address'=> 'Jl karah agung',
                'customer_phone'=> '01283912',
                'date'=> '2021-07-19',
                'brand'=> 'Xiaomi',
                'series'=> 'Poco F3',
                'type'=> 'Handphone',
                'no_imei'=> '9182981298',
                'damage'=> 'Layar Pecah Ganti LCD',
                'clock'=> '19:00',
                'total_service'=> '200000',
                'total_part'=> '500000',
                'total_downpayment'=> '0',
                'discount_price'=> '0',
                'discount_percent'=> '0',
                'total_price'=> '700000',
                'downpayment_date'=> '2021-07-19',
                'payment_date'=> '2021-08-19',
                'work_status'=> 'Progress',
                'equipment'=> 'Tidak Ada',
                'done'=> 'False',
                'pickup_date'=> '2021-08-19',
                'warranty'=> '3 Bulan',
                'technician_id'=> '1',
                'created_by'=> 'Azriel',
                'updated_by'=> '',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
        ]);
    }
}
