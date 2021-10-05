<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class accountMainDetail extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('account_main_detail')->insert([
            [
                'id' => '1',
                'main_id' => '1',
                'name' => 'Kas Kecil',
                'code' => '01',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '2',
                'main_id' => '1',
                'name' => 'Kas Besar',
                'code' => '02',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '3',
                'main_id' => '1',
                'name' => 'Kas Bank',
                'code' => '03',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '4',
                'main_id' => '4',
                'name' => 'Pendapatan Dimuka',
                'code' => '01',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '5',
                'main_id' => '5',
                'name' => 'Pendapatan Jasa',
                'code' => '01',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '6',
                'main_id' => '5',
                'name' => 'Pendapatan Service',
                'code' => '02',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
        ]);
    }
}
