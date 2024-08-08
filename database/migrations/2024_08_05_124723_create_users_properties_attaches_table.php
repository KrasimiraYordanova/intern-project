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
        Schema::create('users_properties_attaches', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('property_attach_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('property_attach_id')->references('id')->on('properties_attaches')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_properties_attaches');

        Schema::table('users_properties_attaches', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['property_attach_id']);

            $table->dropColumn(
                [
                    'user_id',
                    'property_attach_id',
                ]
            );
        });
    }
};
