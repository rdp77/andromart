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
        // DB::table('items')->truncate();
        DB::table('items')->insert([
            [
                'id' => '1',
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
                'id' => '2',
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
            ]);
    }
}
