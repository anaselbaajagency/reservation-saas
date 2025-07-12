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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expert_profile_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('appointment_id');
            $table->integer('rating'); // 1-5 stars
            $table->text('comment')->nullable();
            $table->boolean('is_public')->default(true);
            $table->integer('helpful_count')->default(0);
            $table->timestamps();
            $table->foreign('expert_profile_id')->references('id')->on('expert_profiles')->onDelete('cascade');  
            $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');    
            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
