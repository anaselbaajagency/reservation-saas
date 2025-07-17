<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User', // Single name field
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create sample expert user
        User::create([
            'name' => 'Expert Consultant',
            'email' => 'expert@example.com',
            'password' => Hash::make('password'),
            'role' => 'expert',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create sample client user
        User::create([
            'name' => 'Client Test',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create additional random users
        User::factory(10)->create();
    }
}