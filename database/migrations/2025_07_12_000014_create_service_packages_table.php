<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('service_packages', function (Blueprint $table) {
        $table->id();
        
        // Make absolutely sure this matches expert_profiles.id
        $table->unsignedBigInteger('expert_profile_id');
        
        // Your other columns here...
        $table->string('name');
        $table->text('description');
        $table->decimal('price', 10, 2);
        $table->integer('duration_minutes');
        $table->timestamps();

        // Add the foreign key constraint separately
        $table->foreign('expert_profile_id')
              ->references('id')
              ->on('expert_profiles')
              ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_packages');
    }
};