<?php

namespace App\Providers;

use App\Support\Field;
use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('field', function () {
            return new Field();
        });
    }
}
