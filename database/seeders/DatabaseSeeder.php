<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call([
            UserSeeder::class,
            ExpertProfileSeeder::class,
            SpecialtySeeder::class,
            AvailabilitySlotSeeder::class,
            ReviewSeeder::class,
            PaymentSeeder::class,
            PaymentMethodSeeder::class
        ]);
    }
}