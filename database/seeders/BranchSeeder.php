<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('branches')->insert([
            [
                'id' => '1',
                'area_id' => '1',
                'name' => 'Jenggolo',
                'code' => '011',
                'address' => 'Jl. Jenggolo No.2 H, Pucang, Kec. Sidoarjo, Kabupaten Sidoarjo',
                'phone' => '085156986303',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '2',
                'area_id' => '1',
                'name' => 'Mukmin',
                'code' => '012',
                'address' => 'Jl. KH Mukmin No.74, Kapasan, Sidokare, Kec. Sidoarjo, Kabupaten Sidoarjo',
                'phone' => '085780001113',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
        ]);
    }
}
