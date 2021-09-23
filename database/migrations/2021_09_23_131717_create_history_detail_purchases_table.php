<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryDetailPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_detail_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('history_purchase_id')->nullable();
            $table->unsignedBigInteger('purchasing_detail_id')->nullable();

            $table->string('qty')->default(0);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
            
            $table->foreign('history_purchase_id')->references('id')->on('history_purchases')->onDelete('cascade');
            $table->foreign('purchasing_detail_id')->references('id')->on('purchasing_details')->onDelete('cascade');
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
        Schema::dropIfExists('history_detail_purchases');
    }
}
