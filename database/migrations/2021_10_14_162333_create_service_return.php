<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceReturn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_return', function (Blueprint $table) {
                $table->id();
                $table->String('code');
                $table->integer('user_id');
                $table->date('date');
                $table->double('service_id');
                $table->string('description')->nullable();
                $table->string('type')->nullable();
                $table->string('image')->nullable();
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
        Schema::dropIfExists('service_return');
    }
}
