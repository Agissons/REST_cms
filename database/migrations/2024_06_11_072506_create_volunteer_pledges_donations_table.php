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
        Schema::create('volunteer_pledges_donations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('donations_amount');
            $table->boolean('realised');
            $table->foreignid('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
            $table->foreignid('interaction_id')->references('id')->on('interactions')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vonlunteer_pledges_donations');
    }
};
