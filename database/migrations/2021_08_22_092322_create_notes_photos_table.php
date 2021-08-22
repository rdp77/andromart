<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('notes_id');

            $table->string('photo', 255)->nullable();
            $table->mediumText('description')->nullable();
            
            $table->foreign('notes_id')->references('id')->on('notes')->onDelete('cascade');
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
        Schema::dropIfExists('notes_photos');
    }
}
