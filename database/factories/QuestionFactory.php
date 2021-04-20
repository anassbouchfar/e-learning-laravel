<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {

    return [
        'content' => $faker->sentence($nbWords = 6, $variableNbWords = true).' ?',
        'explication' => $faker->sentence($nbWords = 6, $variableNbWords = true)
    ];
});
