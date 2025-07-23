<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            SpecialtySeeder::class,
            ExpertProfileSeeder::class,
            AvailabilitySlotSeeder::class,
            ReviewSeeder::class,
            PaymentSeeder::class,
            PaymentMethodSeeder::class,
            NotificationSeeder::class,
            ConsultationSessionSeeder::class,
        ]);
    }
}
