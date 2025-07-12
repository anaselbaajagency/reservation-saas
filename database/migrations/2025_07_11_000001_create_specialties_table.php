<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('specialties', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->text('description')->nullable();
            $table->string('icon', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Add fulltext index for search functionality
        DB::statement('ALTER TABLE specialties ADD FULLTEXT idx_fulltext_specialty (name, description)');
    }

    public function down()
    {
        Schema::dropIfExists('specialties');
    }
};
