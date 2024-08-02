<?php

namespace Poing\Earmark\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Don't know how to test this yet.
 *
 * @codeCoverageIgnore
 */
class EarMarkFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'earmark';
    }
}
