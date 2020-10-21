<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;

$factory->define(App\Domain\Client\Zone\Sub\SubZone::class,
    function (Faker $faker) {
        return [
            'zone_id' => App\Domain\Client\Zone\Zone::inRandomOrder()->first()->id,
            'slug' => $faker->slug,
            'name' => $faker->name,
        ];
    }
    );
