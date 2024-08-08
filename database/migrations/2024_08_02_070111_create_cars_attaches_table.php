<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars_attaches', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('car_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('cars_attaches', function (Blueprint $table) {
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars_attaches');
    }
};
