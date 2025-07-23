<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpertProfileFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => function () {
                $user = User::factory()->create();
                $user->assignRole('expert'); // Spatie Role assignment
                return $user->id;
            },
            'biography' => $this->faker->paragraphs(3, true),
            'hourly_rate' => $this->faker->randomFloat(2, 20, 200),
            'verified' => $this->faker->boolean(70),
            'years_experience' => $this->faker->numberBetween(1, 30),
            'education' => $this->faker->randomElement([
                'PhD in Computer Science',
                'MBA from Harvard',
                'Certified Life Coach'
            ]),
            'certifications' => implode(', ', $this->faker->words(3)),
            'languages' => 'English, Spanish',
            'timezone' => $this->faker->timezone,
        ];
    }
}
