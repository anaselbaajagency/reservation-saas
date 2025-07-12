<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;

class SpecialtySeeder extends Seeder
{
    public function run()
    {
        $specialties = [
            ['name' => 'Business Consulting', 'icon' => 'fa-briefcase'],
            ['name' => 'Career Coaching', 'icon' => 'fa-user-tie'],
            ['name' => 'Software Development', 'icon' => 'fa-code'],
            ['name' => 'Financial Planning', 'icon' => 'fa-chart-pie'],
            ['name' => 'Health & Wellness', 'icon' => 'fa-heartbeat']
        ];

        foreach ($specialties as $specialty) {
            Specialty::create($specialty + [
                'description' => fake()->paragraph(),
                'is_active' => true
            ]);
        }
    }
}
