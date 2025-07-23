<?php

namespace Database\Seeders;

use App\Models\ExpertProfile;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class ExpertProfileSeeder extends Seeder
{
    public function run()
    {
        // First ensure the 'expert' role exists
        Role::firstOrCreate(['name' => 'expert']);

        // Get users with expert role using whereHas
        $expertUsers = User::whereHas('roles', function($query) {
            $query->where('name', 'expert');
        })->get();

        // If no experts exist, create 3 with the 'expert' role
        if ($expertUsers->isEmpty()) {
            $expertUsers = User::factory()
                ->count(3)
                ->create()
                ->each(function ($user) {
                    $user->assignRole('expert');
                });
        }

        // Create a profile for each expert user
        foreach ($expertUsers as $user) {
            ExpertProfile::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}