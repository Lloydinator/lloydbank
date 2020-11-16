<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Account;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'balance' => mt_rand(15, 1500),
        'userid' => $faker->unique()->numberBetween(1, 10),
        'phone' => $faker->phoneNUmber,
        'street' => $faker->streetAddress,
        'city' => $faker->city,
        'zip' => $faker->postcode,
    ];
});
