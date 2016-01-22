<?php

namespace App\Providers;

use App\Support\Exif;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton('exif', function () {
            return new Exif();
        });
    }
}
