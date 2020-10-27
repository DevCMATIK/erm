<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use Faker\Generator as Faker;

$factory->define(App\Domain\Client\CheckPoint\CheckPoint::class, function (Faker $faker) {
    return [
        'type_id'=> App\Domain\Client\CheckPoint\Type\CheckPointType::inRandomOrder()->first()->id,
        'slug'=> $faker->slug,
        'name'=> $faker-> name,

    ];
});
