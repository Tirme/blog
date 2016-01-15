<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use Field;
use RepositoryFactory;
use Intervention\Image\ImageManagerStatic as Image;

class AlbumController extends Controller
{
    public function photoList($album_id)
    {
        $repository = RepositoryFactory::create('Gallery\Photo');
        $collection = $repository->getList($album_id);

        return view('admin', [
            'menu' => Field::getMenu(),
            'content' => view('photo.list', [
                'photos' => $collection,
            ]),
        ]);
    }
    public function photoUploadForm($album_id)
    {
        $form = (object) [
            'action' => route('model_store', [
                'model_name' => 'photo',
            ]),
            'album_id' => $album_id,
            'photo_upload' => Field::type('photos', [
                'label' => 'Upload Photos',
            ]),
            'redirect' => [
                'success' => route('gallery_album_photo_list', $album_id),
                'error' => route('gallery_album_photo_form', $album_id),
            ],
            'hash' => Field::cryptHash([
                'model_name' => 'photo',
            ]),
        ];

        return view('admin', [
            'menu' => Field::getMenu(),
            'content' => view('photo.form', [
                'form' => $form,
                'errors' => session('errors', []),
            ]),
        ]);
    }
    public function photoDisplay($album_id, $photo_id)
    {
        $temp_path = storage_path('fields/upload/photo/temp');
        $photo_file = $temp_path.'/'.$photo_id;
        if (file_exists($photo_file)) {
            $image = Image
                ::make($photo_file);
            $exif = $image->exif();
            // $font_path = app_path().'/monaco.ttf';
            // $exif_image = Image::canvas(300, 20, '#000000');
            // $exif_image->text('Test', 0, 20, function($font) {
            //     $font->file(app_path().'/monaco.ttf');
            //     $font->color('#FFFFFF');
            //     $font->size(18);
            // });
            $image->resize(300, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->resizeCanvas(300, 220, 'top')
            // ->insert($exif_image, 'bottom')
            ;

            return $image->response();
        }
    }
}
