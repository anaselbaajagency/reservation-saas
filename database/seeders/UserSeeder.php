<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // First create the roles if they don't exist
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $validationRole = Role::firstOrCreate(['name' => 'validation']);
        $expertRole = Role::firstOrCreate(['name' => 'expert']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // Create superadmin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole($superAdminRole);

        // Create admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole($adminRole);

        // Create validation member
        $validator = User::create([
            'name' => 'Validation Member',
            'email' => 'validation@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $validator->assignRole($validationRole);

        // Create 2 experts
        $expert1 = User::create([
            'name' => 'Expert One',
            'email' => 'expert1@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $expert1->assignRole($expertRole);

        $expert2 = User::create([
            'name' => 'Expert Two',
            'email' => 'expert2@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $expert2->assignRole($expertRole);

        // Create 3 clients
        $client1 = User::create([
            'name' => 'Client One',
            'email' => 'client1@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $client1->assignRole($clientRole);

        $client2 = User::create([
            'name' => 'Client Two',
            'email' => 'client2@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $client2->assignRole($clientRole);

        $client3 = User::create([
            'name' => 'Client Three',
            'email' => 'client3@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
        $client3->assignRole($clientRole);

        // Create additional random users (optional)
        // User::factory(5)->create()->each(function ($user) use ($clientRole) {
        //     $user->assignRole($clientRole);
        // });
    }
}