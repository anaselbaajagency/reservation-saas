<?php

namespace Database\Seeders;

use App\Models\ExpertProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpertProfileSeeder extends Seeder
{
    public function run()
    {
        // First ensure we have expert users
        $expertUsers = User::where('role', 'expert')->get();
        
        // If no experts exist (like if you're running this seeder alone)
        if ($expertUsers->isEmpty()) {
            User::factory()
                ->count(3)
                ->create(['role' => 'expert']);
            $expertUsers = User::where('role', 'expert')->get();
        }

        foreach ($expertUsers as $user) {
            ExpertProfile::create([
                'user_id' => $user->id,
                'biography' => 'Professional expert with years of experience.',
                'hourly_rate' => rand(50, 200),
                'verified' => true,
                // ... other fields
            ]);
        }
    }
}