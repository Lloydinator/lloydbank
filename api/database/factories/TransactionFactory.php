<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
		'details' => 'transaction ID: F'.$faker->numberBetween(100,999).$faker->randomLetter(),
		'amount' => $faker->numberBetween(10,1000),
		'message' => $faker->text(60),
		'publictxn' => $faker->boolean()	
    ];
});
