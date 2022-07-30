<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharingProfitSpendingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sharing_profit_spending', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('ref');
            $table->double('subtraction_total');
            $table->double('total');
            $table->integer('employe_id');
            $table->string('description');
            $table->string('created_by')->nullable();
            // $table->string('created_at')->nullable();
            // $table->string('deleted_by')->nullable();
            // $table->softDeletesTz($column = 'deleted_at', $precision = 0);
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
        Schema::dropIfExists('sharing_profit_spending');
    }
}
