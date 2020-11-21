<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TxnParticipant;
use Faker\Generator as Faker;

$factory->define(TxnParticipant::class, function (Faker $faker) {
    static $increment = 1;
    return [
        'from_user_id' =>  $faker->numberBetween(1,5),
        'to_user_id' => $faker->numberBetween(6,10),
        'transaction_id' => $increment++
    ];
});
