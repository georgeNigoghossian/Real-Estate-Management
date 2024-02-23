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
        Schema::create('reported_clients', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->timestamps();


        });

        Schema::table('reported_clients', function($table) {
            $table->unsignedBigInteger('reporting_user_id')->nullable();
            $table->unsignedBigInteger('reported_user_id')->nullable();
            $table->unsignedBigInteger('report_category_id')->nullable();

            $table->foreign('reporting_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reported_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('report_category_id')->references('id')->on('report_categories')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reported_clients');
    }
};
