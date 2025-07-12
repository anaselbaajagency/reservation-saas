<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('expert_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->text('biography')->nullable();
            $table->decimal('hourly_rate', 10, 2);
            $table->decimal('rating_avg', 3, 2)->default(0.00);
            $table->integer('rating_count')->default(0);
            $table->boolean('verified')->default(false);
            $table->integer('years_experience')->default(0);
            $table->text('education')->nullable();
            $table->text('certifications')->nullable();
            $table->string('languages', 255)->nullable();
            $table->string('timezone', 50)->default('UTC');
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expert_profiles');
    }
};
