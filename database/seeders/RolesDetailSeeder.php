<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles_detail')->truncate();
        for ($id = 1; $id<=45; $id++) {
            DB::table('roles_detail')->insert([
                [
                    'roles_id' => 1,
                    'menu' => $id,
                    'view' => 'on',
                    'create' => 'on',
                    'edit' => 'on',
                    'delete' => 'on',
                    'created_at' => date("Y-m-d h:i:s"),
                    'updated_at' => date("Y-m-d h:i:s"),
                ],

            ]);
        }
    }
}
