<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::extend(function ($value) {
            return preg_replace('/\@define(.+)/', '<?php ${1}; ?>', $value);
        });
    }
    public function register()
    {
        //
    }
}
