<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'lead_id' => $this->faker->randomNumber(5,true),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'mobileno' => $this->faker->phoneNumber(),
            'master1' => 'Master1',
            'master2' => 'Master2',
            'master3' => 'Master3',
            'treatmenttype' => $this->faker->text(5),
            'casetype' => $this->faker->text(5),
            'socialintegration' => $this->faker->url(),
            'location' => $this->faker->city(),
            'casestatus' => 'ACTIVE',
            'receiveddate' => now()
        ];
    }
}
