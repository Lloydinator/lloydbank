<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Account;

class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'balance' => mt_rand(15, 1500),
            'user_id' => $this->faker->unique()->numberBetween(1, 10),
            'phone' => $this->faker->phoneNUmber,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'zip' => $this->faker->postcode
        ];
    }
}
