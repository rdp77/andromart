<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceStatusMutationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_status_mutation', function (Blueprint $table) {
            $table->id();
            $table->integer('service_id');
            $table->integer('technician_id');
            $table->String('index');
            $table->String('image')->nullable();
            $table->String('status');
            $table->String('description');
            $table->string('created_by')->nullable();   
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('service_status_mutation');
    }
}
