<?php

use Faker\Generator as Faker;

$autoIncrement = autoIncrement();

$factory->define(Poing\Earmark\Models\EarMark::class, function (Faker $faker) use ($autoIncrement) {

        $autoIncrement->next();$autoIncrement->next();

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

function autoIncrement()
{
    for ($i = config('earmark.range.min') -1; $i < config('earmark.range.max'); $i++) {
        yield $i;
    }
}
