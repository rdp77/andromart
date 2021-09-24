<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('user_id');
            $table->integer('branch_id');
            $table->integer('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('payment_method')->nullable();
            $table->date('date');
            $table->integer('cash_id');
            $table->integer('warranty_id');
            $table->string('discount_type')->nullable();
            $table->double('discount_price')->nullable();
            $table->double('discount_percent')->nullable();
            $table->double('item_price');
            $table->double('total_price');
            $table->integer('buyer_id');
            $table->integer('sales_id');
            $table->double('sharing_profit_store');
            $table->double('sharing_profit_sales');
            $table->double('sharing_profit_buyer');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
