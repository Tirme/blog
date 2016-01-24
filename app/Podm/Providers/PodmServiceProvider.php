<?php

namespace App\Podm\Providers;

use App\Podm\Support\Podm;
use Illuminate\Support\ServiceProvider;
use View;
// use Validator;
use Illuminate\Support\Facades\Validator;

class PodmServiceProvider extends ServiceProvider
{
    public function boot() {
        Validator::extend('podm_ref', 'App\Podm\Validators\PodmValidator@validateRef');
        // Validator::extend('foo', function($attribute, $value, $parameters, $validator) {
        //     return $value == 'foo';
        // });
        View::addNamespace('PodmView', app_path().'/Podm/Views');
    }
    public function register()
    {
        $this->app->singleton('podm', function () {
            return new Podm();
        });
    }
}
