<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('content_types_id');

            $table->string('title', 255)->nullable();
            $table->string('subtitle', 255)->nullable();
            $table->mediumText('description')->nullable();
            $table->mediumText('image')->nullable();
            $table->string('icon', 50)->nullable();
            $table->mediumText('url')->nullable();
            $table->string('class', 50)->nullable();
            $table->string('position', 50)->nullable();
            
            $table->foreign('content_types_id')->references('id')->on('content_types')->onDelete('cascade');
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
        Schema::dropIfExists('contents');
    }
}
