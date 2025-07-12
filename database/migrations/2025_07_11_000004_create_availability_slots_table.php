<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('availability_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expert_profile_id');
            $table->datetime('start_datetime');
            $table->datetime('end_datetime');
            $table->enum('status', ['available','booked','blocked','cancelled'])->default('available');
            $table->string('recurring_pattern', 50)->default('none');
            $table->date('recurring_end_date')->nullable();
            $table->integer('buffer_time')->default(0); // in minutes
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('expert_profile_id')
                  ->references('id')
                  ->on('expert_profiles')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('availability_slots');
    }
};