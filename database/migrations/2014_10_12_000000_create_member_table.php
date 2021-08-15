<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('identity');
            $table->string('gender');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('status');
            $table->string('religion');
            $table->integer('department');
            $table->integer('profession');
            $table->text('address');
            $table->integer('city');
            $table->string('telp');
            $table->date('register_date');
            $table->integer('role_id');
            $table->string('active');
            $table->string('image');
            $table->string('created_by');
            $table->string('updated_by');
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
        Schema::dropIfExists('users');
    }
}
