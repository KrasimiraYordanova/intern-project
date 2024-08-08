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
        Schema::create('properties_attaches', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('uuid');
            $table->integer('property_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('properties_attaches', function (Blueprint $table) {
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties_attaches');
    }
};
