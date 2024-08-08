<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_properties', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('property_id')->unsigned();
        });

        Schema::table('users_properties', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users_properties', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['property_id']);

            $table->dropColumn(
                [
                    'user_id',
                    'property_id',
                ]
            );
        });
    }
};