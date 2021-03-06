<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Choice;
use Faker\Generator as Faker;

$factory->define(Choice::class, function (Faker $faker,$isCorrect=0) {
    return [
        "content" =>$faker->word(),
        "isCorrect"=>  $isCorrect
    ];
});
