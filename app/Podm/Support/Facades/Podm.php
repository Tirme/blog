<?php

namespace App\Podm\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Podm extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'podm';
    }
}
