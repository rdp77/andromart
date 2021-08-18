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
            $table->integer('customer_id');
            $table->String('customer_name');
            $table->String('customer_address');
            $table->String('customer_phone');
            $table->date('date');
            $table->String('brand');
            $table->String('series');
            $table->String('type');
            $table->String('no_imei');
            $table->String('damage');
            $table->String('clock');
            $table->double('total_service');
            $table->double('total_part');
            $table->double('discount_price');
            $table->double('discount_percent');
            $table->double('total_downpayment');
            $table->double('total_price');
            $table->date('payment_date');
            $table->String('work_status');
            $table->String('equipment');
            $table->String('done');
            $table->date('pickup_date');
            $table->date('downpayment_date');
            $table->String('warranty');
            $table->integer('technician_id');
            $table->string('created_by');   
            $table->string('updated_by');
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
