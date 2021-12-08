<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SaleReturnDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_return_dt', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_return_id');
            $table->integer('sale_detail_id');
            $table->integer('item_id');
            $table->integer('sales_id');
            $table->integer('buyer_id');
            $table->double('qty');
            $table->string('type');
            $table->string('description');
            $table->double('price');
            $table->double('total_price');
            $table->double('total_loss_sales');
            $table->double('total_loss_buyer');
            $table->double('total_loss_store');
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletesTz('deleted_at');
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
        Schema::dropIfExists('sale_return_dt');
    }
}
