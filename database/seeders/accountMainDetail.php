<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            [
                'id' => '7',
                'main_id' => '6',
                'name' => 'Return Service',
                'code' => '01',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '8',
                'main_id' => '6',
                'name' => 'Return Penjualan',
                'code' => '02',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '9',
                'main_id' => '6',
                'name' => 'Operasional',
                'code' => '03',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '10',
                'main_id' => '6',
                'name' => 'Listrik',
                'code' => '04',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '11',
                'main_id' => '3',
                'name' => 'Persediaan Barang Dagang',
                'code' => '01',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '12',
                'main_id' => '4',
                'name' => 'Pendapatan Dimuka Pembelian',
                'code' => '02',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '13',
                'main_id' => '6',
                'name' => 'Air (PDAM)',
                'code' => '05',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '14',
                'main_id' => '7',
                'name' => 'Profit Sharing',
                'code' => '01',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '15',
                'main_id' => '7',
                'name' => 'Fee Back Office',
                'code' => '02',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '16',
                'main_id' => '7',
                'name' => 'Sewa Ruko',
                'code' => '03',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '17',
                'main_id' => '7',
                'name' => 'Sewa Hosting & Domain',
                'code' => '04',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '18',
                'main_id' => '7',
                'name' => 'THR',
                'code' => '05',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '19',
                'main_id' => '6',
                'name' => 'Meeting / Konsumsi',
                'code' => '06',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '20',
                'main_id' => '6',
                'name' => 'Internet',
                'code' => '07',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '21',
                'main_id' => '6',
                'name' => 'Iuran Bulanan',
                'code' => '08',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '22',
                'main_id' => '6',
                'name' => 'Operasional',
                'code' => '09',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '23',
                'main_id' => '6',
                'name' => 'Sosial Internal',
                'code' => '10',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '24',
                'main_id' => '6',
                'name' => 'Wisata',
                'code' => '1',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '25',
                'main_id' => '6',
                'name' => 'Qurban',
                'code' => '12',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '26',
                'main_id' => '6',
                'name' => 'ATK',
                'code' => '13',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '27',
                'main_id' => '5',
                'name' => 'Pendapatan Barang Dagang',
                'code' => '03',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],

        ]);
    }
}
