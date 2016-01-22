<?php

/*

@tasks
1. 調整後台介面，改用Materialize [1]
2. 選擇相簿的首圖、相簿改撈設定的首圖 [1]
3. Exif資訊改由exif欄位統一來源 [3]
4. 移除Exif外的其他Exif欄位(with taske 3) [3]
5. Blog文章相關功能，首頁、列表、文章 [2]
6. Blog選單加上Topics連結 [2]
7. 調整相簿上傳相片的功能，與匯入架構一致 [3]
8. 調整相片Exif的顯示位置與顯示方式 [2]
9. 頁首頁尾的文字更新、頁尾的相關連結更新 [2]

@bugs

1. Cards的Content過長時的顯示問題

*/

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
    Route::get('album/{album_id}/photo/{photo_id}/size/{size}', [
        'as' => 'gallery_album_photo_display',
        'uses' => 'PhotoController@display',
    ]);
    Route::get('test', [
        'as' => 'gallery_test',
        'uses' => 'PhotoController@test',
    ]);
    Route::get('test/arw', [
        'as' => 'gallery_test_arw',
        'uses' => 'PhotoController@testARW',
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
        Route::get('album/{album_id}/photo/{photo_id}/size/{size}', [
            'as' => 'admin_gallery_album_photo_display',
            'uses' => 'AlbumController@photoDisplay',
        ]);
        Route::put('album/{album_id}/photo/list/update', [
            'as' => 'admin_gallery_album_photo_list_update',
            'uses' => 'AlbumController@photoListUpdate',
        ]);
        Route::get('album/{album_id}/photo/form', [
            'as' => 'admin_gallery_album_photo_form',
            'uses' => 'AlbumController@photoUploadForm',
        ]);
        Route::get('photo/import/date/{date}', [
            'as' => 'admin_gallery_album_photo_import_form',
            'uses' => 'AlbumController@photoImportForm',
        ]);
        Route::get('photo/import/display/{photo_id}/size/{size}', [
            'as' => 'admin_gallery_album_photo_import_display',
            'uses' => 'AlbumController@photoImportDisplay',
        ]);
        Route::post('photo/import', [
            'as' => 'admin_gallery_album_photo_import',
            'uses' => 'AlbumController@photoImport',
        ]);
    });
    Route::get('test', 'FieldController@test');
});
