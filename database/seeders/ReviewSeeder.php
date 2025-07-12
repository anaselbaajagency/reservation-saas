<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run()
    {
        // Get completed appointments that don't already have reviews
        $appointments = Appointment::where('status', 'completed')
            ->doesntHave('review')
            ->get();

        foreach ($appointments as $appointment) {
            Review::create([
                'expert_profile_id' => $appointment->expert_profile_id,
                'client_id' => $appointment->client_id,
                'appointment_id' => $appointment->id,
                'rating' => rand(3, 5), // Random rating between 3-5 stars
                'comment' => 'Great session! Learned a lot.',
                'is_public' => true
            ]);
        }
    }
}