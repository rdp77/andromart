<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ["HP Detail 1", "HP Detail 2", "HP Detail 3", "HP Detail 4", "HP Detail 5"];
        for ($i=1; $i < 100; $i++) { 
            $model = new Product;
            $model->type_products_id = 1;
            $model->name = "HP Detail ".$i;
            $model->description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at orci a tellus egestas viverra. Aenean interdum ipsum in massa euismod, ac lacinia nulla tempus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum egestas convallis orci ut iaculis. Vivamus ullamcorper nulla ante. Vivamus quis luctus lorem, a pulvinar odio. Sed dictum, dui lacinia laoreet rhoncus, lectus risus scelerisque dolor, et suscipit turpis justo sed urna. Sed sed pretium eros. Quisque maximus sollicitudin nibh, vel ornare arcu porttitor ac. Etiam eget hendrerit neque. Mauris leo turpis, ullamcorper in dapibus vitae, blandit ac velit. Nam gravida arcu at leo commodo pharetra. Morbi ultrices lorem eros, mattis laoreet enim molestie non. ";
            $model->detail = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque at orci a tellus egestas viverra. Aenean interdum ipsum in massa euismod, ac lacinia nulla tempus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum egestas convallis orci ut iaculis.";
            $model->prize = 2500000;
            $model->save();
        }
    }
}
