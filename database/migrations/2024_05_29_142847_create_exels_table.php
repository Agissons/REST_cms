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
        Schema::create('exels', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',255);
            $table->string('last_name',255);
            $table->string('email',255);
            $table->string('phone_number',30);
            $table->string('question',1500);
            $table->string('primary_zip',10);
            $table->unsignedInteger('donations_amount');
            $table->unsignedInteger('donations_pledged_amount');
            $table->unsignedTinyInteger('priority_level');
            $table->boolean('conv');
            $table->string('status',40);
            $table->timestamp('rappel');
            $table->boolean('wa');
            $table->string('engagement',50);
            $table->unsignedInteger('new_donations_amount');
            $table->string('add_wa',50);
            $table->timestamp('last_contact');
            $table->string('note',1000);
            $table->timestamp('wa_enter_date');
            $table->timestamp('wa_exit_date');
            $table->string('wa_enter_way',50);
            $table->timestamp('wa2_enter_date');
            $table->timestamp('wa2_exit_date');
            $table->timestamp('wa3_enter_date');
            $table->timestamp('wa3_exit_date');
            $table->boolean('appel');
            $table->boolean('info');
            $table->boolean('soutien');
            $table->string('rank',40);
            $table->string('organiser',30);
            $table->string('interactor',30);
            $table->string('interaction',1000);
            $table->string('next_move',1000);
            $table->boolean('db');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exels');
    }
};
