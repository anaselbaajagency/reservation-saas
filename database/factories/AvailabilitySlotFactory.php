<?php

namespace Database\Factories;

use App\Models\AvailabilitySlot; // Make sure this import exists
use App\Models\ExpertProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvailabilitySlotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AvailabilitySlot::class; // This line is crucial

    public function definition()
    {
        $start = $this->faker->dateTimeBetween('+1 day', '+1 month');
        
        return [
            'expert_profile_id' => ExpertProfile::factory(),
            'start_datetime' => $start,
            'end_datetime' => (clone $start)->modify('+1 hour'),
            'status' => 'available',
            'price' => $this->faker->randomFloat(2, 50, 200),
            'buffer_time' => 15
        ];
    }
}