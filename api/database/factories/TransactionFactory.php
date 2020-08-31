<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
		'from' =>  $faker->numberBetween(1,15),
		'to' => $faker->numberBetween(16,30),
		'details' => 'transaction ID: F'.$faker->numberBetween(100,999).$faker->randomLetter(),
		'amount' => $faker->numberBetween(10,1000),
		'currency_id' => $faker->numberBetween(1,2),
		'message' => $faker->text(60)		
    ];
});
