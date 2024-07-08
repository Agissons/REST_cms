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
        Schema::create('activists', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('full_name', 255);
            $table->string('email', 255);
            $table->string('email1', 255);
            $table->string('phone_number', 30);
            $table->boolean('email_opt_in');
            $table->boolean('email1_is_bad');
            $table->boolean('mobile_opt_in');
            $table->boolean('is_mobile_bad');
            $table->boolean('do_not_call');
            $table->boolean('do_not_contact');
            $table->string('primary_address1', 255);
            $table->string('primary_state', 30);
            $table->string('primary_city', 255);
            $table->string('primary_zip', 10);
            $table->string('primary_country_code', 10);
            $table->string('primary_country', 255);
            $table->string('note', 1000);
            $table->unsignedInteger('signup_type');
            $table->boolean('is_prospect');
            $table->boolean('is_supporter');
            $table->unsignedInteger('support_level');
            $table->unsignedInteger('inferred_support_level');
            $table->unsignedInteger('priority_level');
            $table->unsignedInteger('recruiter_id');
            $table->boolean('is_donor');
            $table->boolean('is_fundraiser');
            $table->unsignedInteger('is_ignore_donation_limits');
            $table->unsignedInteger('donations_count');
            $table->unsignedInteger('donations_raised_count');
            $table->unsignedInteger('donations_count_this_cycle');
            $table->unsignedInteger('donations_raised_count_this_cycle');
            $table->boolean('is_volunteer');
            $table->string('availability', 255);
            $table->unsignedInteger('donations_amount');
            $table->unsignedInteger('donations_raised_amount');
            $table->unsignedInteger('donations_pledged_amount');
            $table->unsignedInteger('donations_amount_this_cycle');
            $table->unsignedInteger('donations_raised_amount_this_cycle');
            $table->timestamp('unsubscribed_at');
            $table->timestamp('first_donated_at');
            $table->timestamp('last_donated_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activists');
    }
};
