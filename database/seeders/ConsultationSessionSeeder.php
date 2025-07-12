<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\ConsultationSession;
use Illuminate\Database\Seeder;

class ConsultationSessionSeeder extends Seeder
{
    public function run()
    {
        $appointments = Appointment::where('status', 'confirmed')->get();

        foreach ($appointments as $appointment) {
            ConsultationSession::create([
                'appointment_id' => $appointment->id,
                'start_time' => $appointment->start_datetime,
                'status' => 'scheduled',
                'meeting_platform' => 'Zoom'
            ]);
        }
    }
}