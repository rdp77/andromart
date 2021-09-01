<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->id();
            $table->String('account_id');
            $table->String('name');
            $table->String('parrent_id');
            $table->integer('area_id');
            $table->String('debet_kredit');
            $table->String('active');
            $table->integer('branch_id');
            $table->String('account_type');
            $table->String('group_neraca');
            $table->String('main_id');
            $table->String('main_name');
            $table->double('opening_balance');
            $table->date('opening_date');
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
        Schema::dropIfExists('account_type');
    }
}
