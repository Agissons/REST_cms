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
        Schema::table('emails', function (Blueprint $table) {
            $table->foreignid('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
        });
        Schema::table('phones', function (Blueprint $table) {
            $table->foreignid('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->foreignid('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
        });
        Schema::table('next_moves', function (Blueprint $table) {
            $table->foreignid('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
            $table->foreignid('organizer_id')->references('id')->on('users');
            $table->foreignid('next_move_type')->references('id')->on('next_moves_types');
        });
        Schema::table('volunteers', function (Blueprint $table) {
            $table->foreignid('organizer_id')->references('id')->on('users');
            $table->foreignid('volunteer_scale')->references('id')->on('volunteer_scales');
        });
        Schema::table('interactions', function (Blueprint $table) {
            $table->foreignid('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
            $table->foreignid('interactor_id')->references('id')->on('users');
            $table->foreignid('interaction_type')->references('id')->on('interaction_types');
            $table->foreignid('context_id')->references('id')->on('campaigns');
        });
        Schema::table('campaigns', function (Blueprint $table) {
            $table->foreignid('main_campaign')->references('id')->on('campaigns');
        });
        Schema::table('calls', function (Blueprint $table) {
            $table->foreignid('campaign_id')->references('id')->on('campaigns');
        });
        Schema::table('canals', function (Blueprint $table) {
            $table->foreignid('campaign_id')->references('id')->on('campaigns');
        });
        Schema::table('canal_groups', function (Blueprint $table) {
            $table->foreignid('canal_id')->references('id')->on('canals');
        });

        Schema::table('volunteer_use_groups', function (Blueprint $table) {
            $table->foreignid('groups_id')->references('id')->on('canal_groups');
            $table->foreignid('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
        });
        Schema::table('volunteer_use_canals', function (Blueprint $table) {
            $table->foreignid('canal_id')->references('id')->on('canals');
            $table->foreignid('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
        });
        Schema::table('volunteer_sign_calls', function (Blueprint $table) {
            $table->foreignid('call_id')->references('id')->on('calls');
            $table->foreignid('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
        });
        Schema::table('volunteer_act_campaigns', function (Blueprint $table) {
            $table->foreignid('campaign_id')->references('id')->on('campaigns');
            $table->foreignid('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
        });
        Schema::table('vonlunteer_does_donations', function (Blueprint $table) {
            $table->foreignid('campaign_id')->references('id')->on('campaigns');
            $table->foreignid('volunteer_id')->references('id')->on('volunteers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
