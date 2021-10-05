<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu')->insert([
            [
                'name' => 'Dashboard',
                'icon' => 'fa-fire',
                'url' => route('dashboard'),
                'hover' => '["' . route('dashboard') . '","' . route('dashboard.log') . '"]'
            ],
            [
                'name' => 'Transaksi',
                'icon' => 'fa-exchange-alt',
                'url' => 'javascript:void(0)',
                'hover' => null
            ],
            [
                'name' => 'Finance',
                'icon' => 'fa-money-bill',
                'url' => 'javascript:void(0)',
                'hover' => null
            ],
            [
                'name' => 'Master Data',
                'icon' => 'fa-database',
                'url' => 'javascript:void(0)',
                'hover' => null
            ],
            [
                'name' => 'Gudang',
                'icon' => 'fa-boxes',
                'url' => 'javascript:void(0)',
                'hover' => null
            ],
            // [
            //     'name' => 'Kantor',
            //     'icon' => 'fa-building',
            //     'url' => 'javascript:void(0)',
            //     'hover' => null
            // ],
            [
                'name' => 'Konten',
                'icon' => 'fa-file-alt',
                'url' => 'javascript:void(0)',
                'hover' => null
            ],
            [
                'name' => 'System',
                'icon' => 'fa-cog',
                'url' => 'javascript:void(0)',
                'hover' => null
            ],
        ]);
    }
}
