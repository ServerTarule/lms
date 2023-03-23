<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'contact' => $this->faker->phoneNumber(),
            'dob' => $this->faker->dateTime(),
            'doj' => $this->faker->dateTime(),
            'alternate_contact' => $this->faker->phoneNumber(),
            'designation_id' => 1,
            'profile_img' => $this->faker->imageUrl(),
            'lead_assigned_at' => $this->faker->dateTime()
        ];
    }
}
