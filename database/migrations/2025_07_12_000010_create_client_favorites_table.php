<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('client_favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('expert_profile_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['client_id', 'expert_profile_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_favorites');
    }
};