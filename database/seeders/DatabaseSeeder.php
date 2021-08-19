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
            User::class,
            ServiceSeeder::class,
            ServiceDetailSeeder::class,
            EmployeeSeeder::class,
            AreaSeeder::class,
            BranchSeeder::class,
            RoleSeeder::class,
            CategorySeeder::class,
            UnitSeeder::class,
            SupplierSeeder::class,
            ItemSeeder::class,
        ]);
    }
}
