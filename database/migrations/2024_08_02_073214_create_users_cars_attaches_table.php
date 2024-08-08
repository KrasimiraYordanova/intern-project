<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_cars_attaches', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('car_attach_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('car_attach_id')->references('id')->on('cars_attaches')->onDelete('cascade')->onUpdate('cascade');
        });
           
    }

    public function down(): void
    {
        Schema::dropIfExists('users_cars_attaches');

        Schema::table('users_cars_attaches', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['car_attach_id']);

            $table->dropColumn(
                [
                    'user_id',
                    'car_attach_id',
                ]
            );
        });
    }
};
