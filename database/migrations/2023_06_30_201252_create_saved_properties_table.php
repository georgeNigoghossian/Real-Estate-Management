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
        Schema::create('saved_properties', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

        });

        Schema::table('saved_properties', function($table) {
            $table->unsignedBigInteger('property_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_properties');
    }
};
