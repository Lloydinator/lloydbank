<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Transaction;

class TransactionFactory extends Factory
{

    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'from' =>  $this->faker->numberBetween(1,5),
            'to' => $this->faker->numberBetween(6,10),
            'details' => 'TXN'.$this->faker->numberBetween(100,999).strtoupper($this->faker->randomLetter()),
            'amount' => $this->faker->numberBetween(1,300),
            'message' => $this->faker->text(60),
            'publictxn' => $this->faker->boolean()
        ];
    }
}
