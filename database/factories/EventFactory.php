<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'description' => $faker->firstName,
        'description_in_form' => $faker->firstName,
        'quota'  => $faker->numberBetween(1,100)
    ];
});
