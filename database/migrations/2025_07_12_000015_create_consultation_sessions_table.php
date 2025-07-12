<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('consultation_sessions', function (Blueprint $table) {
        $table->id();
        
        // Ensure this matches appointments.id exactly
        $table->unsignedBigInteger('appointment_id');
        
        // Other columns...
        $table->text('notes')->nullable();
        $table->string('status');
        $table->timestamps();
        
        // Add foreign key separately
        $table->foreign('appointment_id')
              ->references('id')
              ->on('appointments')
              ->onDelete('cascade');
    });
    }

    public function down()
    {
        Schema::dropIfExists('consultation_sessions');
    }
};