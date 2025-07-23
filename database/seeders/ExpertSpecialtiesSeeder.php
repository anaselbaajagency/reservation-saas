<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpertSpecialtiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

public function run()
{
    // First ensure expert profiles exist
    $experts = \App\Models\User::role('expert')->get();
    
    foreach ($experts as $expert) {
        // Create expert profile if doesn't exist
        $expertProfile = \App\Models\ExpertProfile::firstOrCreate(
            ['user_id' => $expert->id],
            ['bio' => 'Default bio', /* other default fields */]
        );
        
        // Attach 1-3 random specialties
        $specialties = \App\Models\Specialty::inRandomOrder()
            ->limit(rand(1, 3))
            ->pluck('id');
            
        $expertProfile->specialties()->sync($specialties);
    }
}
}
