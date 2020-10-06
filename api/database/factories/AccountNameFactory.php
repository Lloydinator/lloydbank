<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Account;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'balance' => mt_rand(20, 100000),
        'userid' => $faker->unique()->numberBetween(1, 30)
    ];
});
