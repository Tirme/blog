<?php

namespace App\Fields\Providers;

use App\Fields\Support\Field;
use Illuminate\Support\ServiceProvider;
use View;
// use Validator;
use Illuminate\Support\Facades\Validator;

class FieldServiceProvider extends ServiceProvider
{
    public function boot() {
        Validator::extend('Fields', 'App\Fields\Validators\FieldValidator@validateItemByModel');
        // Validator::extend('foo', function($attribute, $value, $parameters, $validator) {
        //     return $value == 'foo';
        // });
        View::addNamespace('FieldsView', app_path().'/Fields/Views');
    }
    public function register()
    {
        $this->app->singleton('field', function () {
            return new Field();
        });
    }
}
