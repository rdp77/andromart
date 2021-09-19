<?php

namespace Database\Seeders;

use App\Models\PurchasingDetail;
use Illuminate\Database\Seeder;

class PurchasingDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PurchasingDetail::create([
            'purchasing_id' => 1,
            'item_id' => 2,
            'unit_id' => 1,
            'branch_id' => 1,
            'price' => 135000,
            'qty' => 10,
            'total' => 1350000,
        ]);
    }
}
