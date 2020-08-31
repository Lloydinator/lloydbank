<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Account;
use Faker\Generator as Faker;

$factory->define(Account::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
		'balance' => mt_rand(20, 1000000),
		'currency_id' => rand(1,2)
    ];
});
