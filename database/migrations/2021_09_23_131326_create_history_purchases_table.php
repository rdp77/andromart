<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchasing_id')->nullable();

            $table->datetime('date')->nullable();
            $table->mediumText('image')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
            
            $table->foreign('purchasing_id')->references('id')->on('purchasings')->onDelete('cascade');
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
        Schema::dropIfExists('history_purchases');
    }
}
