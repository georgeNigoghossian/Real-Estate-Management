<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residentials', function (Blueprint $table) {
            $table->id();
            $table->integer('num_of_bedrooms')->nullable();
            $table->integer('num_of_bathrooms')->nullable();
            $table->integer('num_of_balconies')->nullable();
            $table->integer('num_of_living_rooms')->nullable();
            $table->integer('floor')->nullable();
            $table->json('specialAttributes');
            $table->timestamps();

        });
        Schema::table('residentials', function($table) {
            $table->unsignedBigInteger('property_id')->nullable();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('residentials');
    }
};
