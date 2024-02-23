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
        Schema::create('rate_agencies', function (Blueprint $table) {
            $table->id();
            $table->double('rate')->nullable();
            $table->date('rate_date')->nullable();
            $table->timestamps();


        });

        Schema::table('rate_agencies', function($table) {
            $table->unsignedBigInteger('agency_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
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
        Schema::dropIfExists('rate_agencies');
    }
};
