<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_types', function (Blueprint $table) {
            $table->id();
            $table->string('type', 100)->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('column_1')->default(0);
            $table->boolean('column_2')->default(0);
            $table->boolean('column_3')->default(0);
            $table->boolean('column_4')->default(0);
            $table->boolean('column_5')->default(0);
            $table->boolean('column_6')->default(0);
            $table->boolean('column_7')->default(0);
            $table->boolean('column_8')->default(0);
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
        Schema::dropIfExists('content_types');
    }
}
