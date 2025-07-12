<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expert_profile_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('slot_id');
            $table->datetime('start_datetime');
            $table->datetime('end_datetime');
            $table->enum('status', ['pending','confirmed','completed','cancelled','rescheduled','no_show'])->default('pending');
            $table->text('notes')->nullable();
            $table->text('client_notes')->nullable();
            $table->text('expert_notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->unsignedBigInteger('rescheduled_from')->nullable();
            $table->boolean('reminder_sent')->default(false);
            $table->timestamps();

            $table->foreign('expert_profile_id')
                  ->references('id')
                  ->on('expert_profiles')
                  ->onDelete('cascade');
                  
            $table->foreign('client_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
                  
            $table->foreign('slot_id')
                  ->references('id')
                  ->on('availability_slots')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};