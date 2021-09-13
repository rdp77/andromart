<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AreaSeeder::class,
            BranchSeeder::class,
            BrandSeeder::class,
            TypeSeeder::class,
            CategorySeeder::class,
            ContentTypeSeeder::class,
            ContentSeeder::class,
            EmployeeSeeder::class,
            ItemSeeder::class,
            CashSeeder::class,
            ServiceDetailSeeder::class,
            ServiceSeeder::class,
            SupplierSeeder::class,
            StockSeeder::class,
            RoleSeeder::class,
            UnitSeeder::class,
            User::class,
            IconSeeder::class,
            WarrantySeeder::class,
            SettingPresentase::class,
            RegulationSeeder::class,
            NotesSeeder::class,
        ]);
    }
}
