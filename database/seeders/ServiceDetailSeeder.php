<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('service_detail')->insert([
        //     [
        //         'id' => '1',
        //         'service_id' => '1', 
        //         'item_id' =>'1',
        //         'price' => '500000',
        //         'qty' => '1',
        //         // 'loss' => '500000',
        //         // 'sparepart' => '500000',
        //         'total_price' => '500000',
        //         'description' => 'LCD Xiaomi',
        //         'type' => 'SparePart',
        //         'created_by'=> 'Azriel',
        //         'updated_by'=> '',
        //         'created_at' => date("Y-m-d h:i:s"),
        //         'updated_at' => date("Y-m-d h:i:s"),
        //     ],
        //     [
        //         'id' => '2',
        //         'service_id' =>'1',
        //         'item_id' =>'2',
        //         'price' =>'200000',
        //         'qty' =>'1',
        //         // 'loss' => '500000',
        //         // 'sparepart' => '500000',
        //         'total_price' => '500000',
        //         'description' =>'Jasa Pemasangan',
        //         'type' =>'Jasa',
        //         'created_by'=> 'Azriel',
        //         'updated_by'=> '',
        //         'created_at' => date("Y-m-d h:i:s"),
        //         'updated_at' => date("Y-m-d h:i:s"),
        //     ],
        // ]);
    }
}
