<?php

namespace App\Podm\Support\Facades;

use Illuminate\Support\Facades\Facade;

class RepositoryFactory extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'repository_factory';
    }
}
