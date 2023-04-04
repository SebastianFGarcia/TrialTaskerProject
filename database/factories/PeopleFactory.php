<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\People>
 */
class PeopleFactory extends Factory
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
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'nit' => $this->faker->randomNumber(8),
            'issue_nit' => $this->faker->date(),
            'num_ministry' => $this->faker->randomNumber(8),
            'num_dispach' => $this->faker->randomNumber(8),
            'radicated' => $this->faker->randomNumber(8),
            'authority' => $this->faker->randomNumber(8),
            'number' => $this->faker->randomNumber(8),
            'type_people_id' => $this->faker->numberBetween(1, 20),
        ];
    }
}
