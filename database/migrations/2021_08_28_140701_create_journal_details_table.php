<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_details', function (Blueprint $table) {
            $table->id();
            $table->String('journal_id');
            $table->integer('account_id');
            $table->double('total');
            $table->String('description');
            $table->String('debet_kredit');
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
        Schema::dropIfExists('journal_details');
    }
}
