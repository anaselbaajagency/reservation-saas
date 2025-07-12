<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('expert_specialties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expert_profile_id');
            $table->unsignedBigInteger('specialty_id');
            $table->timestamps();

            $table->foreign('expert_profile_id')
                  ->references('id')
                  ->on('expert_profiles')
                  ->onDelete('cascade');
                  
            $table->foreign('specialty_id')
                  ->references('id')
                  ->on('specialties')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expert_specialties');
    }
};