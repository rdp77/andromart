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
                'identity' => '1461800028',
                'name' => 'admin',
                'contact' => '082140644679',
                'address' => 'Wonorejo,Surabaya',
                'level' => 'teknisi',
                'gender' => 'L',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '2',
                'user_id' => '2',
                'branch_id' => '1',
                'identity' => '1461800028',
                'name' => 'Rio',
                'contact' => '082140644679',
                'address' => 'Wonorejo,Surabaya',
                'level' => 'teknisi',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '3',
                'user_id' => '3',
                'branch_id' => '1',
                'identity' => '1461800028',
                'name' => 'Asep',
                'contact' => '082140644679',
                'address' => 'Wonorejo,Surabaya',
                'level' => 'teknisi',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
        ]);
    }
}
