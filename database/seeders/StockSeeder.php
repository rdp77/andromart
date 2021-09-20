<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stocks')->insert([
            [
                'item_id' => '1',
                'unit_id' => '1',
                'branch_id' => '1',
                'stock' => '0',
                'description' => 'Jasa Service',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'item_id' => '2',
                'unit_id' => '1',
                'branch_id' => '1',
                'stock' => '1',
                'description' => 'LCD BARU',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'item_id' => '3',
                'unit_id' => '1',
                'branch_id' => '1',
                'stock' => '1',
                'description' => ' ',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'item_id' => '4',
                'unit_id' => '1',
                'branch_id' => '1',
                'stock' => '1',
                'description' => ' ',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'item_id' => '5',
                'unit_id' => '1',
                'branch_id' => '1',
                'stock' => '1',
                'description' => ' ',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'item_id' => '6',
                'unit_id' => '1',
                'branch_id' => '1',
                'stock' => '1',
                'description' => ' ',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'item_id' => '7',
                'unit_id' => '1',
                'branch_id' => '1',
                'stock' => '1',
                'description' => ' ',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
        ]);
    }
}
