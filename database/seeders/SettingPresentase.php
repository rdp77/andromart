<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SettingPresentase extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting_presentase')->truncate();

        DB::table('setting_presentase')->insert([
            [
                'id' => '1',
                'name' => 'Presentase Sharing Profit Toko',
                'total' => '60',
                'created_by' => 'Administrator',
                'updated_by' => date("Y-m-d h:i:s"),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '2',
                'name' => 'Presentase Sharing Profit Teknisi',
                'total' => '40',
                'created_by' => 'Administrator',
                'updated_by' => date("Y-m-d h:i:s"),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '3',
                'name' => 'Presentase Sharing Profit Teknisi 1',
                'total' => '5',
                'created_by' => 'Administrator',
                'updated_by' => date("Y-m-d h:i:s"),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '4',
                'name' => 'Presentase Sharing Profit Teknisi 2',
                'total' => '35',
                'created_by' => 'Administrator',
                'updated_by' => date("Y-m-d h:i:s"),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '5',
                'name' => 'Presentase Loss Toko',
                'total' => '40',
                'created_by' => 'Administrator',
                'updated_by' => date("Y-m-d h:i:s"),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '6',
                'name' => 'Presentase Loss Teknisi',
                'total' => '60',
                'created_by' => 'Administrator',
                'updated_by' => date("Y-m-d h:i:s"),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '7',
                'name' => 'Presentase Loss Teknisi 1',
                'total' => '10',
                'created_by' => 'Administrator',
                'updated_by' => date("Y-m-d h:i:s"),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '8',
                'name' => 'Presentase Loss Teknisi 2',
                'total' => '50',
                'created_by' => 'Administrator',
                'updated_by' => date("Y-m-d h:i:s"),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '9',
                'name' => 'Default Loss Maximum',
                'total' => '3',
                'created_by' => 'Administrator',
                'updated_by' => date("Y-m-d h:i:s"),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '10',
                'name' => 'Batasan Maximum Handle Customer Pada Teknisi',
                'total' => '10',
                'created_by' => 'Administrator',
                'updated_by' => date("Y-m-d h:i:s"),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
        ]);
    }
}
