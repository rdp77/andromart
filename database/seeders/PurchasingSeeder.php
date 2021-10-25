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
            'employee_id' => 1,
            'date' => date('Y-m-d H:i:s'),
            'code' => 'PCS-10001010',
            'price' => 1350000,
            'discount' => 50000,
            'status' => 'debt',
        ]);
    }
}