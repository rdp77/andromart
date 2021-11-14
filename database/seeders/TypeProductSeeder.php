<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeProduct;

class TypeProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nama = ["Handphone", "Laptop 1", "Laptop 2", "Laptop 3"];
        foreach ($nama as $key => $value) {
            $model = new TypeProduct;
            $model->name = $value;
            $model->image = $key.".jpg";
            $save = $model->save();
        }
    }
}
