<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'id' => '1',
                'name' => 'Sparepart',
                'code' => 'SPT',
            ],
            [
                'id' => '2',
                'name' => 'Handphone',
                'code' => 'HP',
            ],
            [
                'id' => '3',
                'name' => 'Laptop',
                'code' => 'LP',
            ],
            [
                'id' => '4',
                'name' => 'Komputer',
                'code' => 'PC',
            ],
        ]);

    }
}
