<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountMainDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_main_detail', function (Blueprint $table) {
            $table->id();
            $table->String('code');
            $table->integer('main_id');
            $table->String('name');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
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
        Schema::dropIfExists('account_main_detail');
    }
}
