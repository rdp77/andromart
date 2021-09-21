<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchasing_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('purchasing_id');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('branch_id');

            $table->string('price')->default(0);
            $table->string('qty')->default(0);
            $table->string('total')->default(0);
            $table->mediumText('description')->nullable();

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
            
            $table->foreign('purchasing_id')->references('id')->on('purchasings')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');

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
        Schema::dropIfExists('purchasing_details');
    }
}
