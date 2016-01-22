<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use RepositoryFactory;
use Intervention\Image\ImageManagerStatic as Image;
use Imagick;
use Exif;

class PhotoController extends Controller
{
    public function test()
    {

    }
    public function testARW()
    {
        $raw_file = storage_path('DSC00303.ARW');
        if (file_exists($raw_file)) {
            $imagick = new Imagick($raw_file);
            $imagick->setImageFormat('jpg');
            header('Content-Type: image/'.$imagick->getImageFormat());
            echo $imagick;
        }
    }
    public function display($album_id, $photo_id, $size)
    {
        $album = with(RepositoryFactory::create('Gallery\Album'))
            ->get($album_id);
        if ($album === null) {
            return redirect('/');
        }
        $repository = RepositoryFactory::create('Gallery\Photo');
        $photo = $repository->get($photo_id);
        $photo_file = storage_path(strtr('photos/{date}/{size}/{file_name}', [
            '{date}' => $photo->date,
            '{size}' => $size,
            '{file_name}' => $photo->file_name,
        ]));
        if (file_exists($photo_file)) {
            $image = Image::make($photo_file);
        } else {
            $image = Image::canvas('300', '300');
            $image->text('404', 150, 126, function ($font) {
                $font_file = resource_path('fonts').'/monaco.ttf';
                $font->file($font_file);
                $font->size(48);
                $font->align('center');
                $font->valign('top');
            });
        }

        return $image->response();
    }
}
