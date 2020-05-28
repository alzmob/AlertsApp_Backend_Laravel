<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\City;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(City::class, function (Faker $faker) {
    $name = $faker->city;
    return [
        'name' => $name,
        'slug' => Str::slug($name),
        'lat' => $faker->latitude($min = -90, $max = 90), //77.147489
        'long' => $faker->longitude($min = -180, $max = 180)  // 86.211205
    ];
});
