<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class accountData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('account_data')->insert([
            [
                'id' => '1',
                'code' => '110101011',
                'name' => 'Kas Kecil Cabang Pusat',
                'area_id' => '1',
                'branch_id' => '1',
                'active' => 'Y',
                'account_type' => '-',
                'debet_kredit' => 'D',
                'main_id' => '1',
                'main_detail_id' => '1',
                'opening_balance' => 0,
                'opening_date' => date('Y-m-d'),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '2',
                'code' => '110101012',
                'name' => 'Kas Kecil Cabang Mukmin',
                'area_id' => '1',
                'branch_id' => '2',
                'active' => 'Y',
                'account_type' => '-',
                'debet_kredit' => 'D',
                'main_id' => '1',
                'main_detail_id' => '1',
                'opening_balance' => 0,
                'opening_date' => date('Y-m-d'),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            // [
            //     'id' => '3',
            //     'code' => '140101011',
            //     'name' => 'Pendapatan Dimuka Cabang Pusat',
            //     'area_id' => '1',
            //     'branch_id' => '1',
            //     'active' => 'Y',
            //     'account_type' => '-',
            //     'debet_kredit' => 'D',
            //     'main_id' => '1',
            //     'main_detail_id' => '1',
            //     'opening_balance' => 0,
            //     'opening_date' => date('Y-m-d'),
            //     'created_at' => date("Y-m-d h:i:s"),
            //     'updated_at' => date("Y-m-d h:i:s"),
            // ],
            // [
            //     'id' => '4',
            //     'code' => '140101012',
            //     'name' => 'Pendapatan Dimuka Cabang Mukmin',
            //     'area_id' => '1',
            //     'branch_id' => '2',
            //     'debet_kredit' => 'D',
            //     'active' => 'Y',
            //     'account_type' => '-',
            //     'main_id' => '1',
            //     'main_detail_id' => '1',
            //     'opening_balance' => 0,
            //     'opening_date' => date('Y-m-d'),
            //     'created_at' => date("Y-m-d h:i:s"),
            //     'updated_at' => date("Y-m-d h:i:s"),
            // ],
            [
                'id' => '3',
                'code' => '410101011',
                'name' => 'Pendapatan Jasa Cabang Pusat',
                'area_id' => '1',
                'branch_id' => '1',
                'active' => 'Y',
                'account_type' => '-',
                'debet_kredit' => 'D',
                'main_id' => '5',
                'main_detail_id' => '5',
                'opening_balance' => 0,
                'opening_date' => date('Y-m-d'),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '4',
                'code' => '410101012',
                'name' => 'Pendapatan Jasa Cabang Mukmin',
                'area_id' => '1',
                'branch_id' => '2',
                'debet_kredit' => 'D',
                'active' => 'Y',
                'account_type' => '-',
                'main_id' => '5',
                'main_detail_id' => '5',
                'opening_balance' => 0,
                'opening_date' => date('Y-m-d'),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '5',
                'code' => '410201011',
                'name' => 'Pendapatan Barang Service Cabang Pusat',
                'area_id' => '1',
                'branch_id' => '1',
                'active' => 'Y',
                'account_type' => '-',
                'debet_kredit' => 'D',
                'main_id' => '5',
                'main_detail_id' => '6',
                'opening_balance' => 0,
                'opening_date' => date('Y-m-d'),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '6',
                'code' => '410201012',
                'name' => 'Pendapatan Barang Service Cabang Mukmin',
                'area_id' => '1',
                'branch_id' => '2',
                'debet_kredit' => 'D',
                'active' => 'Y',
                'account_type' => '-',
                'main_id' => '5',
                'main_detail_id' => '6',
                'opening_balance' => 0,
                'opening_date' => date('Y-m-d'),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],

        ]);
    }
}