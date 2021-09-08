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
            CategorySeeder::class,
            ContentTypeSeeder::class,
            ContentSeeder::class,
            EmployeeSeeder::class,
            ItemSeeder::class,
            StockSeeder::class,
            ServiceDetailSeeder::class,
            ServiceSeeder::class,
            SupplierSeeder::class,
            StockSeeder::class,
            RoleSeeder::class,
            UnitSeeder::class,
            User::class,
            IconSeeder::class,
        ]);
    }
}
