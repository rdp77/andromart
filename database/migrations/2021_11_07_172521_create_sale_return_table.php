<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleReturnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_return', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('sale_id');
            $table->integer('item_id');
            $table->date('date');
            $table->date('type');
            $table->text('description')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('account');
            $table->double('item_price_old')->nullable();
            $table->double('item_price')->nullable();
            $table->double('total_price')->nullable();
            $table->double('total_loss_store')->nullable();
            $table->double('total_loss_sales')->nullable();
            $table->double('total_loss_buyer')->nullable();
            $table->string('discount_type')->nullable();
            $table->double('discount_price')->nullable();
            $table->double('discount_percent')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('sale_return');
    }
}
