<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'prefix' => 'admin',
    'middleware' => ['web'],
], function () {
    Route::get('{model_name}/list', [
        'as' => 'model_list',
        'uses' => 'FieldController@listPage',
    ]);
    Route::get('{model_name}/create', [
        'as' => 'model_create',
        'uses' => 'FieldController@create',
    ]);
    Route::get('{model_name}/edit/{id}', [
        'as' => 'model_edit',
        'uses' => 'FieldController@edit',
    ]);
    Route::post('{model_name}/store', [
        'as' => 'model_store',
        'uses' => 'FieldController@store',
    ]);
    Route::post('{model_name}/update', [
        'as' => 'model_update',
        'uses' => 'FieldController@update',
    ]);
    Route::post('upload/photo', [
        'as' => 'model_upload_photo',
        'uses' => 'FieldController@uploadPhoto',
    ]);
    Route::group([
        'prefix' => 'gallery',
        'namespace' => 'Gallery',
    ], function () {
        Route::get('album/{album_id}/photo/list', [
            'as' => 'gallery_album_photo_list',
            'uses' => 'AlbumController@photoList',
        ]);
        Route::get('album/{album_id}/photo/upload', [
            'as' => 'gllery_album_photo_upload',
            'uses' => 'AlbumController@photoUploadForm',
        ]);
    });
    Route::get('test', 'FieldController@test');
});
