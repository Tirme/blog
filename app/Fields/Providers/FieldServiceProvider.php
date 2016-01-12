<?php

namespace App\Fields\Providers;

use App\Fields\Support\Field;
use Illuminate\Support\ServiceProvider;
use View;

class FieldServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('field', function () {
            return new Field();
        });
        View::addNamespace('FieldsView', app_path().'/Fields/Views');
    }
}
