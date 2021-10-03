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
        Schema::create('account_data', function (Blueprint $table) {
            $table->id();
            // $table->String('account_id');
            $table->String('code');
            $table->String('name');
            // $table->integer('parent_id');
            $table->integer('area_id');
            $table->integer('branch_id');
            $table->String('debet_kredit');
            $table->String('active');
            $table->String('account_type');
            // $table->String('group_neraca');
            $table->integer('main_id');
            $table->integer('main_detail_id');
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
        Schema::dropIfExists('account_data');
    }
}
