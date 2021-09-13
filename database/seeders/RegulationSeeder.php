<?php

namespace Database\Seeders;


use App\Models\Regulation;
use Illuminate\Database\Seeder;

class RegulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Regulation::create([
            'role_id' => 1,
            'branch_id' => 1,
            'date' => date('Y-m-d'),
            'title' => 'SOP untuk Admin',
        ]);
    }
}
