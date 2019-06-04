<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Prefix & Suffix
    |--------------------------------------------------------------------------
    | The default string to affix to the befining of the digits.
    |
    */

    'prefix' => null,
    'suffix' => null, // for future use

    /*
    |--------------------------------------------------------------------------
    | Zero Padding
    |--------------------------------------------------------------------------
    | The number of zeros to prefix the digits with.  To provide uniformity.
    |
    */

    'padding' => 8,

    /*
    |--------------------------------------------------------------------------
    | Hold
    |--------------------------------------------------------------------------
    | This value detemines how many numbers are available for imediate use.
    | Numbers held for quick retreival, without the need to parse the primay
    | table every time a number is requested.
    | 
    | Once the hold drops below one-third of this value, it is refilled.
    |
    */

    'hold' => 10,

    /*
    |--------------------------------------------------------------------------
    | Number Ranges
    |--------------------------------------------------------------------------
    | This determines the starting number of the sequence.
    |
    */

    'range' => [

        'min' => 4000,
        'max' => 5000, // for future use

    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Model
    |--------------------------------------------------------------------------
    | Use your own model and column vaules.  Use at your own risk.
    |
    */

    /*
    'model' => Poing\Earmark\Models\EarMark::class,

    'columns' => [
        'digit' => 'digit',  // The interger
        'group' => 'group',  // The prefix string
    ],
    */

];
