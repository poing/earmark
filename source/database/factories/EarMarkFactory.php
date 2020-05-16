<?php

use Faker\Generator as Faker;
use Poing\Earmark\Helpers\Boost;

$foo = new Boost;
$count = $foo->autoIncrement();

$factory->define(Poing\Earmark\Models\EarMark::class, function (Faker $faker) use ($count) {
    $count->next();
    $count->next();

    return [
        /*
        'digit' => $faker->numberBetween(
            config('earmark.range.min'),
            config('earmark.range.max')
        ),
    */
        'digit' => $autoIncrement->current(),
        'prefix' => config('earmark.prefix'),
        'type' => $faker->word,
    ];
});
