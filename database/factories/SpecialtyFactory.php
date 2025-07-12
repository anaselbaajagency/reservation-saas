<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SpecialtyFactory extends Factory
{
    public function definition()
    {
        return [
            'nom' => $this->faker->unique()->jobTitle(),
            'description' => $this->faker->paragraph(),
            'icon' => $this->faker->randomElement(['fa-code', 'fa-heart', 'fa-chart-line']),
            'is_active' => true
        ];
    }
}
