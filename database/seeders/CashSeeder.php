<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CashSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cashes')->insert([
            [
                'id' => '1',
                'name' => 'Kas Toko',
                'code' => 'KT',
                'balance' => '1000000',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '2',
                'name' => 'Debit BCA',
                'code' => 'BCA',
                'balance' => '5000000',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '3',
                'name' => 'Debit Mandiri',
                'code' => 'MANDIRI',
                'balance' => '2000000',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
        ]);
    }
}
