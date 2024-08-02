<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Poing\Earmark\Helpers\Boost;
use Poing\Earmark\Models\EarMark;

class EarMarkFactory extends Factory
{
    protected $model = EarMark::class;

    public function definition()
    {
        $boost = new Boost;
        $count = $boost->autoIncrement();

        $count->next();
        $count->next();

        return [
            'digit' => $count->current(),
            'prefix' => config('earmark.prefix'),
            'type' => $this->faker->word,
        ];
    }
}
