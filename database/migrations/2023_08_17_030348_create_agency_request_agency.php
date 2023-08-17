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
        Schema::create('agency_request_agency', function (Blueprint $table) {
            $table->id();
//            $table->timestamps();
        });
        Schema::table('agency_request_agency', function($table) {
            $table->unsignedBigInteger('agency_id');
            $table->unsignedBigInteger('agency_request_id');

            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
            $table->foreign('agency_request_id')->references('id')->on('agency_requests')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agency_request_agency');
    }
};
