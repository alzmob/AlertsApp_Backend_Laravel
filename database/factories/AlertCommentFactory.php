<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Alert;
use App\Models\User;
use App\Models\AlertComment;
use Faker\Generator as Faker;

$factory->define(AlertComment::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return User::all()->random();
        },
        'alert_id' => function () {
            return Alert::all()->random();
        },
        'body' => $faker->sentence($nbWords = 4, $variableNbWords = true)
    ];
});
