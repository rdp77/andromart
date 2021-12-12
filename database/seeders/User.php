<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => '1',
                'name' => 'Puller',
                'username' => 'puller',
                'password' => Hash::make('admin'),
                'role_id' => '1',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            [
                'id' => '2',
                'name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'role_id' => '1',
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ],
            // [
            //     'id' => '3',
            //     'name' => 'Rio',
            //     'username' => 'Teknisi 1',
            //     'password' => Hash::make('admin'),
            //     'role_id' => '5',
            //     'created_at' => date("Y-m-d h:i:s"),
            //     'updated_at' => date("Y-m-d h:i:s"),
            // ],
            // [
            //     'id' => '4',
            //     'name' => 'Asep',
            //     'username' => 'Teknisi 2',
            //     'password' => Hash::make('admin'),
            //     'role_id' => '5',
            //     'created_at' => date("Y-m-d h:i:s"),
            //     'updated_at' => date("Y-m-d h:i:s"),
            // ],
        ]);
    }
}
