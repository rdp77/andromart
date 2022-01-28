<?php

namespace Database\Seeders;

use App\Models\SubMenu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesDetailSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles_detail')->truncate();
        $sub = SubMenu::get('id');
        $subs = count($sub);
        for ($id = 1; $id<=$subs; $id++) {
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
                [
                    'roles_id' => 2,
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
