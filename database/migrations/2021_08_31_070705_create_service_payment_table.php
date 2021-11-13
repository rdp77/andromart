<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_payment', function (Blueprint $table) {
            $table->id();
            $table->String('code');
            $table->integer('user_id');
            $table->integer('service_id');
            $table->date('date')->nullable();
            $table->double('total');
            $table->string('type')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->string('payment_method')->nullable();
            $table->integer('account');
            $table->string('created_by')->nullable();   
            $table->string('updated_by')->nullable();
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_payment');
    }
}
