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
                'id' => '1',
                'item_id' => '1',
                'unit_id' => '1',
                'branch_id' => '1',
                'stock' => '0',
                'description' => 'Jasa Service',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '2',
                'item_id' => '2',
                'unit_id' => '1',
                'branch_id' => '1',
                'stock' => '0',
                'description' => ' ',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
        ]);
    }
}
