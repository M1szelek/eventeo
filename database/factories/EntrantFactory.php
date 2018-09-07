<?php

use Faker\Generator as Faker;

$factory->define(App\Entrant::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'event_id' => $faker->numberBetween(1,5)

    ];
});
