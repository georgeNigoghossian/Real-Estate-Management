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
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->double('rate')->nullable()->default(0);
            $table->integer('is_verified')->nullable()->default(0);
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->json('contact_info')->nullable();
            $table->timestamps();

        });

        Schema::table('agencies', function($table) {
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agencies');
    }
};
