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
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',255);
            $table->string('last_name',255);
            $table->string('primary_address1',255)->nullable();
            $table->string('primary_state',30)->nullable();
            $table->string('primary_city',255)->nullable();
            $table->string('primary_zip',10)->nullable();
            $table->string('primary_country_code',10)->nullable();
            $table->string('primary_country',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteers');
    }
};
