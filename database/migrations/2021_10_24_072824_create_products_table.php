<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_products_id');

            $table->string('name');
            $table->integer('prize')->nullable();
            $table->string('image')->nullable();
            $table->longText('description')->nullable();
            $table->mediumText('detail')->nullable();
            
            $table->string('shopee')->nullable();
            $table->string('tokopedia')->nullable();
            $table->string('lazada')->nullable();
            $table->string('bukalapak')->nullable();
            $table->string('olx')->nullable();
            $table->string('blibli')->nullable();
            $table->string('jd')->nullable();
            $table->string('bhinneka')->nullable();

            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->softDeletesTz($column = 'deleted_at', $precision = 0);
            
            $table->foreign('type_products_id')->references('id')->on('type_products')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
