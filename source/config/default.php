<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Range
    |--------------------------------------------------------------------------
    |
    |
    */

    'model' => Poing\Earmark\Models\EarMark::class,

    'columns' => [
        'digit' => 'digit',
        'group' => 'prefix',
    ],


    'hold_model' => Poing\Earmark\Models\Hold::class,
    'accrual' => Poing\Earmark\Models\Accrual::class,

];
