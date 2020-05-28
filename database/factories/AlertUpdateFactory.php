<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Alert;
use App\Models\AlertUpdate;
use Faker\Generator as Faker;

$factory->define(AlertUpdate::class, function (Faker $faker) {
    return [
        'alert_id' => function () {
            return Alert::all()->random();
        },
        'description' => $faker->paragraph($nbSentences = 2, $variableNbSentences = true)
    ];
});
