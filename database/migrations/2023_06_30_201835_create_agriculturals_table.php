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
        Schema::create('agriculturals', function (Blueprint $table) {
            $table->id();
            $table->json('specialAttributes')->nullable();
            $table->timestamps();
        });

        Schema::table('agriculturals', function($table) {
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
        Schema::dropIfExists('agriculturals');
    }
};
