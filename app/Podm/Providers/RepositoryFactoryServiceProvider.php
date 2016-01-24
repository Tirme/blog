<?php

namespace App\Podm\Providers;

use App\Podm\Support\RepositoryFactory;
use Illuminate\Support\ServiceProvider;

class RepositoryFactoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('repository_factory', function () {
            return new RepositoryFactory();
        });
    }
}
