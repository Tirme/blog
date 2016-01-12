<?php

namespace App\Fields\Providers;

use App\Fields\Support\RepositoryFactory;
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
