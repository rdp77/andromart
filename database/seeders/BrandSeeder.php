<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            [
                'id' => '1',
                'category_id' => '1',
                'name' => 'No Brand',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            // [
            //     'id' => '2',
            //     'category_id' => '2',
            //     'name' => 'APPLE',
            //     'created_at' => date("Y-m-d h:i:s"),
            //     'updated_at' => date("Y-m-d h:i:s"),
            // ],
            // [
            //     'id' => '3',
            //     'category_id' => '3',
            //     'name' => 'APPLE',
            //     'created_at' => date("Y-m-d h:i:s"),
            //     'updated_at' => date("Y-m-d h:i:s"),
            // ],
        ]);
    }
}
