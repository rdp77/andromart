<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'name' => 'Jasa Service',
                'brand_id' => '1',
                'supplier_id' => '1',
                'buy' => '0',
                'sell' => '0',
                'discount' => '0',
                'image' => ' ',
                'condition' => 'Baru',
                'description' => 'Jasa Service',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'LCD 14"',
                'brand_id' => '1',
                'supplier_id' => '1',
                'buy' => '90000',
                'sell' => '150000',
                'discount' => '0',
                'image' => ' ',
                'condition' => 'Baru',
                'description' => 'LCD anti retak anti maling',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'POWER SUPPLY 400W',
                'brand_id' => '1',
                'supplier_id' => '1',
                'buy' => '400000',
                'sell' => '600000',
                'discount' => '0',
                'image' => ' ',
                'condition' => 'Baru',
                'description' => '80+ Gold',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'IPHONE 5',
                'brand_id' => '2',
                'supplier_id' => '1',
                'buy' => '1500000',
                'sell' => '1800000',
                'discount' => '0',
                'image' => ' ',
                'condition' => 'Bekas',
                'description' => 'Biru Laut',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'MACBOOK 12 PRO',
                'brand_id' => '3',
                'supplier_id' => '1',
                'buy' => '10000000',
                'sell' => '13000000',
                'discount' => '0',
                'image' => ' ',
                'condition' => 'Bekas',
                'description' => 'Silver',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
        ]);
    }
}
