<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use Field;
use RepositoryFactory;
use Intervention\Image\ImageManagerStatic as Image;

class AlbumController extends Controller
{
    public function listPage() {
        $albums = with(RepositoryFactory::create('Gallery\Album'))
            ->getRows(10);
        return view('home', [
            'albums' => $albums
        ]);
    }
    public function photoListPage($album_id)
    {
        $album = with(RepositoryFactory::create('Field\Field'))
            ->get('album', $album_id);
        if ($album === null) {
            return redirect('/');
        }
        $photos = with(RepositoryFactory::create('Gallery\Photo'))
            ->getList($album_id);

        return view('gallery.photo.list', [
            'album' => $album,
            'photos' => $photos,
        ]);
    }
    public function photoDisplay($album_id, $photo_id)
    {
        $album = with(RepositoryFactory::create('Gallery\Album'))
            ->get($album_id);
        if ($album === null) {
            return redirect('/');
        }
        $temp_path = storage_path('fields/upload/photo/temp');
        $photo_file = $temp_path.'/'.$photo_id;
        // if (file_exists($photo_file)) {
        //     $image = Image::make($photo_file);
        //     if ($image->width() > $image->height()) {
        //         $resize_width = 600;
        //         $resize_height = 360;
        //     } else {
        //         $resize_width = 360;
        //         $resize_height = 600;
        //     }
        //     $image->resize($resize_width, $resize_height, function ($constraint) {
        //         $constraint->aspectRatio();
        //     });
        //
        //     return $image->response();
        // }
    }
}
