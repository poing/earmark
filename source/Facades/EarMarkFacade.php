<?php

namespace Poing\Earmark\Facades;

use Illuminate\Support\Facades\Facade;

class EarMarkFacade extends Facade
{
    protected static function getFacadeAccessor() 
    { 
        return 'earmark';
    }
}