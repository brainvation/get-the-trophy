<?php

namespace Database\Factories;

use GetTheTrophy\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'privacy_consent' => true,
            'external_service' => 'Web',
            'external_id' => $this->faker->randomNumber,
        ];
    }
}
