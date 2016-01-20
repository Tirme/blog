<?php

namespace App\Http\Controllers\Gallery\Admin;

use App\Http\Controllers\Controller;
use Field;
use RepositoryFactory;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class AlbumController extends Controller
{
    public function photoList($album_id)
    {
        $album = with(RepositoryFactory::create('Field\Field'))
            ->get('album', $album_id);
        if ($album === null) {
            return redirect()->route('model_list', [
                'model_name' => 'album',
            ]);
        }
        $photos = with(RepositoryFactory::create('Gallery\Photo'))
            ->getList($album_id);

        return view('FieldsView::fields', [
            'menu' => Field::getMenu(),
            'content' => view('gallery.photo.admin.list', [
                'album' => $album,
                'photos' => $photos,
            ]),
        ]);
    }
    public function photoUploadForm($album_id)
    {
        $album = with(RepositoryFactory::create('Field\Field'))->get('album', $album_id);
        if ($album === null) {
            return redirect('/');
        }
        $form = (object) [
            'action' => route('model_store', [
                'model_name' => 'photo',
            ]),
            'album_id' => $album_id,
            'photo_upload' => Field::type('photos', [
                'label' => 'Upload Photos',
            ]),
            'redirect' => [
                'success' => route('admin_gallery_album_photo_list', $album_id),
                'error' => route('admin_gallery_album_photo_form', $album_id),
            ],
            'hash' => Field::cryptHash([
                'model_name' => 'photo',
            ]),
        ];

        return view('FieldsView::fields', [
            'menu' => Field::getMenu(),
            'content' => view('gallery.photo.admin.form', [
                'form' => $form,
                'errors' => session('errors', []),
            ]),
        ]);
    }
    public function photoImportDisplay($folder_name, $file_name)
    {
        $resize1 = 960;
        $resize2 = 540;
        $dir = storage_path('photos/'.$folder_name);
        $cache_path = storage_path(
            sprintf('photos/cache_%sx%s/%s', $resize1, $resize2, $folder_name)
        );
        $photo_file = $dir.'/'.$file_name;
        if (file_exists($photo_file)) {
            $cache_file = $cache_path.'/'.$file_name;
            if (file_exists($cache_file)) {
                $image = Image::make($cache_file);
            } else {
                $image = Image::make($photo_file);
                $mine_type = mime_content_type($photo_file);
                if ($image->width() > $image->height()) {
                    $resize_width = $resize1;
                    $resize_height = $resize2;
                } else {
                    $resize_width = $resize2;
                    $resize_height = $resize1;
                }
                $image->resize($resize_width, $resize_height, function ($constraint) {
                    $constraint->aspectRatio();
                });
                if (!is_dir($cache_path)) {
                    if (mkdir($cache_path, 0777, true)) {
                        $image->save($cache_path.'/'.$file_name);
                    }
                } else {
                    $image->save($cache_path.'/'.$file_name);
                }
            }
            $exif = Image::make($photo_file)->exif();
            // dd($exif);
            $exif_text = strtr('{Make} {Model} Aperture: {FNumber} Shutter: {ExposureTime}', [
                '{Make}' => $exif['Make'],
                '{Model}' => $exif['Model'],
                '{FNumber}' => $exif['FNumber'],
                '{ExposureTime}' => $exif['ExposureTime'],
            ]);
            $exif_image = Image::canvas($image->width(), 25, '#000000');
            $exif_image->text($exif_text, 20, 20, function ($font) {
                $font_file = resource_path('fonts').'/monaco.ttf';
                $font->file($font_file);
                $font->color('#FFFFFF');
                $font->size(18);
            });
            $image->resizeCanvas($image->width(), $image->height() + $exif_image->height(), 'top')
                ->insert($exif_image, 'bottom')
            ;

            return $image->response();
        } else {
            // no photo
        }
    }
    public function photoImportForm(Request $request, $folder_name)
    {
        $photos = [];
        $dir = storage_path('photos/'.$folder_name);
        $cache_path = storage_path('photos/cache/'.$folder_name);
        if (is_dir($dir)) {
            $page = $request->get('page', 1);
            $perpage = 12;
            $glob = glob($dir.'/*.jpg');
            $paginator = new LengthAwarePaginator($glob, count($glob), $perpage, $page);
            $paginator->setPath('admin/gallery/photos/import/'.$folder_name);
            $files = collect($glob);
            $photo_files = $files->forPage($page, $perpage);
            foreach ($photo_files as $photo_file) {
                $file_name = basename($photo_file);
                $cache_file = $cache_path.'/'.$file_name;
                if (file_exists($cache_file)) {
                    $image = Image::make($cache_file);
                    $mine_type = mime_content_type($cache_file);
                    if ($image->width() > $image->height()) {
                        $direction = 'horizontal';
                    } else {
                        $direction = 'vertical';
                    }
                } else {
                    $mine_type = mime_content_type($photo_file);
                    $image = Image::make($photo_file);
                    if ($image->width() > $image->height()) {
                        $resize_width = 300;
                        $resize_height = 200;
                        $direction = 'horizontal';
                    } else {
                        $resize_width = 200;
                        $resize_height = 300;
                        $direction = 'vertical';
                    }
                    $image->resize($resize_width, $resize_height, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    if (!is_dir($cache_path)) {
                        if (mkdir($cache_path, 0777, true)) {
                            $image->save($cache_path.'/'.$file_name);
                        }
                    } else {
                        $image->save($cache_path.'/'.$file_name);
                    }
                }
                $base64 = base64_encode($image->encode($mine_type));
                $photos[] = [
                    '$file_name' => $file_name,
                    'mine_type' => $mine_type,
                    'base64' => $base64,
                    'direction' => $direction,
                ];
            }
        } else {
            return redirect()->route('model_list', [
                'model_name' => 'album',
            ]);
        }
        $form = (object) [
            'action' => route('admin_gallery_album_photo_import'),
            'album' => Field::type('select', [
                'label' => 'Album',
                'column' => 'Name',
                'name' => 'album_id',
                'options' => function () {
                    $options = [];
                    $model = Field::getModel('Album');
                    $albums = $model->getAll();
                    foreach ($albums as $album) {
                        $options[$album->getId()] = $album->name;
                    }

                    return $options;
                },
            ]),
        ];

        return view('FieldsView::fields', [
            'menu' => Field::getMenu(),
            'content' => view('gallery.photo.admin.import', [
                'form' => $form,
                'errors' => session('errors', []),
                'folder_name' => $folder_name,
                'photos' => $photos,
                'paginator' => $paginator,
            ]),
        ]);
    }
    public function photoImport(Request $request)
    {
        $album_id = $request->get('album_id', null);
        dd($request->all());
        //save & save file
    }
}
