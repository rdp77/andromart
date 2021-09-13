<?php

namespace Database\Seeders;

use App\Models\Purchasing;
use Illuminate\Database\Seeder;

class PurchasingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Purchasing::create([
            'supplier_id' => 1,
            'date' => date('Y-m-d H:i:s'),
            'code' => 'ini kode',
        ]);
    }
}
