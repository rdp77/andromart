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
                'id' => '1',
                'name' => 'LCD 16x2',
                'category_id' => '1',
                'branch_id' => '1',
                'supplier_id' => '1',
                'buy' => '135000',
                'sell' => '170000',
                'discount' => '1000',
                'image' => ' ',
                'status' => '1',
                'keterangan' => 'LCD anti retak anti maling',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ]
            ]);
    }
}
