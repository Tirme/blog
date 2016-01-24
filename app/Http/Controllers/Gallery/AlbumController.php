<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use Podm;
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
        $album = with(RepositoryFactory::create('Gallery\Album'))
            ->get($album_id);
        if ($album === null) {
            return redirect('/');
        }
        $collection = with(RepositoryFactory::create('Gallery\Photo'))
            ->getAll($album_id);
        $photos = $collection->each(function($item) {
            $item->src = route('gallery_album_photo_display', [
                'album_id' => $item->album_id,
                'photo_id' => $item->id,
                'size' => 'large'
            ]);
            return $item;
        });
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
