<?php

namespace App\Podm\Providers;

use App\Podm\Support\Podm;
use Illuminate\Support\ServiceProvider;
use View;
use Route;
use Illuminate\Support\Facades\Validator;

class PodmServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->addRoute();
        $this->addValidator();
        View::addNamespace('PodmView', app_path().'/Podm/Views');
    }

    public function register()
    {
        $this->app->singleton('podm', function () {
            return new Podm();
        });
    }
    protected function addRoute()
    {
        $controller_namespace = 'App\Podm\Http\Controllers';
        Route::group([
            'prefix' => 'admin',
            'middleware' => ['web'],
            'namespace' => $controller_namespace,
        ], function () {
            Route::get('login', [
                'as' => 'admin_login',
                'uses' => 'AuthenticateController@login'
            ]);
            Route::post('login', [
                'as' => 'admin_login_auth',
                'uses' => 'AuthenticateController@loginAuth'
            ]);
            Route::get('logout', [
                'as' => 'admin_logout',
                'uses' => 'AuthenticateController@logout'
            ]);
            Route::get('test', 'PodmController@test');
        });
        Route::group([
            'prefix' => 'admin',
            'middleware' => ['web', 'admin'],
            'namespace' => $controller_namespace,
        ], function() {
           Route::get('{model_name}/list', [
                'as' => 'model_list',
                'uses' => 'PodmController@listPage',
            ]);
            Route::get('{model_name}/create', [
                'as' => 'model_create',
                'uses' => 'PodmController@createPage',
            ]);
            Route::get('{model_name}/{id}/edit', [
                'as' => 'model_edit',
                'uses' => 'PodmController@editPage',
            ]);
            Route::post('{model_name}/store', [
                'as' => 'model_store',
                'uses' => 'PodmController@store',
            ]);
            Route::post('{model_name}/update', [
                'as' => 'model_update',
                'uses' => 'PodmController@update',
            ]);
            Route::post('upload/photo', [
                'as' => 'model_upload_photo',
                'uses' => 'PodmController@uploadPhoto',
            ]); 
        });
    }
    protected function addValidator()
    {
        Validator::extend('podm_ref', 'App\Podm\Validators\PodmValidator@validateRef');
    }
}
