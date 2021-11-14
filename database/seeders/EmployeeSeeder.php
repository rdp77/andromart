<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            [
                'id' => '1',
                'user_id' => '1',
                'branch_id' => '1',
                'identity' => '001',
                'name' => 'Puller',
                'contact' => '085755145397',
                'address' => 'Andromart',
                'level' => '1',
                'gender' => 'L',
                'status' => 'aktif',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '2',
                'user_id' => '2',
                'branch_id' => '1',
                'identity' => '1461800001',
                'name' => 'Admin',
                'contact' => '82140644679',
                'address' => 'Wonorejo,Surabaya',
                'level' => '1',
                'gender' => 'L',
                'status' => 'aktif',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '3',
                'user_id' => '3',
                'branch_id' => '1',
                'identity' => '1461800002',
                'name' => 'Rio',
                'contact' => '82140644679',
                'address' => 'Wonorejo,Surabaya',
                'level' => '2',
                'gender' => 'L',
                'status' => 'aktif',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '4',
                'user_id' => '4',
                'branch_id' => '1',
                'identity' => '1461800003',
                'name' => 'Asep',
                'contact' => '82140644679',
                'address' => 'Wonorejo,Surabaya',
                'level' => '3',
                'gender' => 'P',
                'status' => 'aktif',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
        ]);
    }
}
