<?php

namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Exif extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'exif';
    }
}
