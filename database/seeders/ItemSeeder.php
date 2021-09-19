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
                'category_id' => '1',
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
                'name' => 'LCD 16x2',
                'category_id' => '1',
                'supplier_id' => '1',
                'buy' => '135000',
                'sell' => '170000',
                'discount' => '1000',
                'image' => ' ',
                'condition' => 'Baru',
                'description' => 'LCD anti retak anti maling',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'name' => 'Realme 3 PRO',
                'category_id' => '2',
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
                'name' => 'MSI GF63',
                'category_id' => '3',
                'supplier_id' => '1',
                'buy' => '10000000',
                'sell' => '12000000',
                'discount' => '0',
                'image' => ' ',
                'condition' => 'Baru',
                'description' => 'Merah Hitam',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            ]);

    }
}
