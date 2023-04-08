<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stage>
 */
class StageFactory extends Factory
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
            'description' => $this->faker->text,
            'procedure_date' => $this->faker->date,
            'process_id' => $this->faker->numberBetween(1, 10),
            'type_stage_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
