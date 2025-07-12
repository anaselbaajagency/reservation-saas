<?php

namespace Database\Seeders;

use App\Models\AvailabilitySlot;
use App\Models\ExpertProfile;
use Illuminate\Database\Seeder;

class AvailabilitySlotSeeder extends Seeder
{
    public function run()
    {
        // Get all expert profiles
        $experts = ExpertProfile::all();

        // Create 3 availability slots for each expert
        $experts->each(function ($expert) {
            AvailabilitySlot::factory()
                ->count(3)
                ->create(['expert_profile_id' => $expert->id]);
        });
    }
}