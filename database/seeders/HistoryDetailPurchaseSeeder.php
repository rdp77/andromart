<?php

namespace Database\Seeders;

use App\Models\HistoryDetailPurchase;
use Illuminate\Database\Seeder;

class HistoryDetailPurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HistoryDetailPurchase::create([
            'history_purchase_id' => 1,
            'purchasing_detail_id' => 1,
        ]);
    }
}
