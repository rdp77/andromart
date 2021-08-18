<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ServiceDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     
    public function up()
    {
        Schema::create('service_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id');
            $table->integer('item_id');
            $table->double('price');
            $table->double('qty');
            $table->double('total_pice');
            $table->String('description');
            $table->String('type');
            $table->string('created_by');   
            $table->string('updated_by');
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service');
    }
}
