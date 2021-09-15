<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->String('code');
            $table->integer('user_id');
            $table->integer('branch_id');
            $table->integer('customer_id')->nullable();
            $table->String('customer_name')->nullable();
            $table->String('customer_address')->nullable();
            $table->String('customer_phone')->nullable();
            $table->date('date');
            $table->date('estimate_date');
            $table->String('brand')->nullable();
            $table->String('series')->nullable();
            $table->String('type')->nullable();
            $table->String('no_imei')->nullable();
            $table->String('complaint')->nullable();
            $table->String('clock');
            $table->double('total_service');
            $table->double('total_part');
            $table->double('discount_price');
            $table->double('discount_percent');
            $table->double('total_price');

            $table->double('total_payment')->nullable();
            $table->double('total_downpayment')->nullable();
            $table->date('payment_date')->nullable();
            $table->date('downpayment_date')->nullable();
            $table->String('payment_status')->nullable();
            $table->String('work_status');
            $table->String('equipment')->nullable();
            $table->date('pickup_date')->nullable();
            $table->integer('technician_id');
            $table->integer('technician_replacement_id')->nullable();
            $table->string('description')->nullable();
            $table->string('warranty_id');
            $table->string('verification_price');
            $table->double('total_loss');
            $table->double('total_loss_technician_1');
            $table->double('total_loss_technician_2');
            $table->double('total_loss_store');
            $table->String('image')->nullable();
            $table->double('sharing_profit_store');
            $table->double('sharing_profit_technician_1');
            $table->double('sharing_profit_technician_2');
            $table->string('created_by')->nullable();   
            $table->string('updated_by')->nullable();
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
        Schema::dropIfExists('service');
    }
}
