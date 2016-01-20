<?php

Route::get('/', [
    'as' => 'home',
    'uses' => 'IndexController@homePage',
]);
Route::group([
    'prefix' => 'blog',
    'middleware' => ['web'],
    'namespace' => 'Blog',
], function() {
    Route::get('', [
        'as' => 'blog_article_list',
        'uses' => 'ArticleController@listPage'
    ]);
});
Route::group([
    'prefix' => 'gallery',
    'middleware' => ['web'],
    'namespace' => 'Gallery',
], function() {
    Route::get('', [
        'as' => 'gallery_album_list',
        'uses' => 'AlbumController@listPage'
    ]);
    Route::get('album/{album_id}/photo/list', [
        'as' => 'gallery_album_photo_list',
        'uses' => 'AlbumController@photoListPage',
    ]);
    Route::get('album/{album_id}/photo/{photo_id}', [
        'as' => 'gallery_album_photo_display',
        'uses' => 'PhotoController@display',
    ]);
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
    Route::get('{model_name}/{id}/edit', [
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
        'namespace' => 'Gallery\Admin',
    ], function () {
        Route::get('album/{album_id}/photo/list', [
            'as' => 'admin_gallery_album_photo_list',
            'uses' => 'AlbumController@photoList',
        ]);
        Route::get('album/{album_id}/photo/form', [
            'as' => 'admin_gallery_album_photo_form',
            'uses' => 'AlbumController@photoUploadForm',
        ]);
        Route::get('photos/import/display/{folder_name}/{file_name}', [
            'as' => 'admin_gallery_album_photo_import_display',
            'uses' => 'AlbumController@photoImportDisplay',
        ]);
        Route::get('photos/import/{folder_name}', [
            'as' => 'admin_gallery_album_photo_import_form',
            'uses' => 'AlbumController@photoImportForm',
        ]);
        Route::post('photos/import', [
            'as' => 'admin_gallery_album_photo_import',
            'uses' => 'AlbumController@photoImport',
        ]);
    });
    Route::get('test', 'FieldController@test');
});
