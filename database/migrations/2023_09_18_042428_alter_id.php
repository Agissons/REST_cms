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
        Schema::table('mealworms', function (Blueprint $table) {
            $table->foreignid('sets_id')->references('id')->on('sets');
            $table->foreignid('boxes_id')->references('id')->on('boxes');
            $table->unique('code','sets_id');
        });

        Schema::table('boxes', function (Blueprint $table) {
            $table->foreignid('sets_id')->references('id')->on('sets');
            $table->foreignid('users_id')->references('id')->on('users');
            $table->foreignid('types_id')->references('id')->on('types');
            $table->unique('name','sets_id');
        });

        Schema::table('users_give_aliments', function (Blueprint $table) {
            $table->foreignid('users_id')->references('id')->on('users');
            $table->foreignid('aliments_id')->references('id')->on('aliments');
        });

        Schema::table('users_work_sets', function (Blueprint $table) {
            $table->foreignid('sets_id')->references('id')->on('sets');
            $table->foreignid('users_id')->references('id')->on('users');
        });

        Schema::table('handlings', function (Blueprint $table) {
            $table->foreignid('sets_id')->references('id')->on('sets');
        });

        Schema::table('handlings_boxes', function (Blueprint $table) {
            $table->foreignid('boxes_id')->references('id')->on('boxes');
            $table->foreignid('handlings_id')->references('id')->on('handlings');
        });

        Schema::table('users_does_handlings', function (Blueprint $table) {
            $table->foreignid('users_id')->references('id')->on('users');
            $table->foreignid('handlings_id')->references('id')->on('handlings');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
