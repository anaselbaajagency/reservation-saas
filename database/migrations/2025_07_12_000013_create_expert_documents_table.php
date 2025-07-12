<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('expert_documents', function (Blueprint $table) {
            $table->id();
            // Make sure this matches the expert_profiles.id type exactly
            $table->unsignedBigInteger('expert_profile_id');
            $table->enum('document_type', ['id_proof', 'certification', 'portfolio', 'other']);
            $table->string('file_path');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            // Add foreign key separately
            $table->foreign('expert_profile_id')
                  ->references('id')
                  ->on('expert_profiles')
                  ->onDelete('cascade');
    });
    }

    public function down()
    {
        Schema::dropIfExists('expert_documents');
    }
};