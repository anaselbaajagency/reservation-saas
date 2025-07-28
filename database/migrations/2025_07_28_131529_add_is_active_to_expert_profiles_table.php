<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('expert_profiles', function (Blueprint $table) {
            $table->boolean('is_active')
                  ->default(true)
                  ->after('verified');
        });
    }

    public function down()
    {
        Schema::table('expert_profiles', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};