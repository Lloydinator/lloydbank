<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
		'from' =>  $faker->numberBetween(1,5),
        'to' => $faker->numberBetween(6,10),
		'details' => 'F'.$faker->numberBetween(100,999).strtoupper($faker->randomLetter()),
		'amount' => $faker->numberBetween(1,300),
		'message' => $faker->text(60),
		'publictxn' => $faker->boolean()	
    ];
});
