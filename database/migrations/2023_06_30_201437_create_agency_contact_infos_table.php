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
        Schema::create('agency_contact_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('facebook');
            $table->string('mobile');
            $table->timestamps();

        });
        Schema::table('agency_contact_infos', function($table) {
            $table->unsignedBigInteger('agency_id')->nullable();

            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agency_contact_infos');
    }
};
