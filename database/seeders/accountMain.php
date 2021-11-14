<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class accountMain extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_main')->insert([
            [
                'id' => '1',
                'name' => 'Kas',
                'code' => '11',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '2',
                'name' => 'Piutang',
                'code' => '12',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '3',
                'name' => 'Persediaan',
                'code' => '13',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '4',
                'name' => 'Uang Muka',
                'code' => '14',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '5',
                'name' => 'Pendapatan',
                'code' => '41',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '6',
                'name' => 'Biaya',
                'code' => '51',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '7',
                'name' => 'Beban',
                'code' => '50',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
        ]);
    }
}
