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
        Schema::create('amenities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->integer('active')->nullable()->default('1');
            $table->timestamps();


        });
        Schema::table('amenities', function ($table) {
            $table->unsignedBigInteger('amenity_type_id')->nullable();
            $table->foreign('amenity_type_id')->references('id')->on('amenity_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amenities');
    }
};
