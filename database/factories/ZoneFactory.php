<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;

$factory->define(App\Domain\Client\Zone\Zone::class,
    function (Faker $faker) {
        return [
            'slug' => $faker->slug,
            'name' => $faker->name,
            'display_name' => $faker->name
        ];
    });
