<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\City;
use App\Models\User;
use App\Models\Alert;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Alert::class, function (Faker $faker) {
    $title = $faker->sentence;
    return [
        'user_id' => function () {
            return User::all()->random();
        },
        'city_id' => function () {
            return City::all()->random();
        },
        'title' => $title,
        'slug' => Str::slug($title),
        'lat' => $faker->latitude($min = -90, $max = 90), //77.147489
        'long' => $faker->longitude($min = -180, $max = 180),  // 86.211205
        'published' => $faker->boolean($chanceOfGettingTrue = 70) // true
    ];
});
