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
                'hover' => '["service.edit","purchase.edit","sale.edit","reception.edit","payment.edit"]'
            ],
            [
                'name' => 'Finance',
                'icon' => 'fa-money-bill',
                'url' => 'javascript:void(0)',
                'hover' => '["sharing-profit.edit","service-payment.edit","loss-items.edit"]'
            ],
            [
                'name' => 'Master Data',
                'icon' => 'fa-database',
                'url' => 'javascript:void(0)',
                'hover' => '["item.edit","employee.edit","customer.edit","presentase.edit","warranty.edit","supplier.edit","unit.edit","type.edit","brand.edit","category.edit","cost.edit","cash.edit","branch.edit","area.edit","menu.edit"]'
            ],
            [
                'name' => 'Gudang',
                'icon' => 'fa-boxes',
                'url' => 'javascript:void(0)',
                'hover' => null
            ],
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
