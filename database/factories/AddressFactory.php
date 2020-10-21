<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(App\Domain\WaterManagement\Device\Address\Address::class,
    function (Faker $faker) {
        return [
            'slug' => $faker->slug,
            'name' => $faker->name,
            'configuration_type' => $faker->word,
            'register_type_id' => rand(8, 12),
        ];
    });
