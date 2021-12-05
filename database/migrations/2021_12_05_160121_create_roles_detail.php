<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('roles_id')->nullable();
            $table->integer('menu')->nullable();
            $table->string('view')->nullable();
            $table->string('create')->nullable();
            $table->string('edit')->nullable();
            $table->string('delete')->nullable();
            $table->string('branch')->nullable();
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
        Schema::dropIfExists('roles_detail');
    }
}
