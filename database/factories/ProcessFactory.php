<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Process>
 */
class ProcessFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'radicate' => $this->faker->randomNumber(8),
            'description' => $this->faker->text,
            'status' => $this->faker->boolean,
            'user_id' => $this->faker->numberBetween(1, 2),
            'people_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
