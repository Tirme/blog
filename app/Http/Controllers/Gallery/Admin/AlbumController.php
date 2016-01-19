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
            return redirect('/');
        }
        $photos = with(RepositoryFactory::create('Gallery\Photo'))
            ->getList($album_id);

        return view('FieldsView::fields', [
            'menu' => Field::getMenu(),
            'content' => view('photo.list', [
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
                'success' => route('gallery_album_photo_list', $album_id),
                'error' => route('gallery_album_photo_form', $album_id),
            ],
            'hash' => Field::cryptHash([
                'model_name' => 'photo',
            ]),
        ];

        return view('FieldsView::fields', [
            'menu' => Field::getMenu(),
            'content' => view('photo.form', [
                'form' => $form,
                'errors' => session('errors', []),
            ]),
        ]);
    }
    public function photoDisplay($album_id, $photo_id)
    {
        $album = with(RepositoryFactory::create('Field\Field'))
            ->get('album', $album_id);
        if ($album === null) {
            return redirect('/');
        }
        $temp_path = storage_path('fields/upload/photo/temp');
        $photo_file = $temp_path.'/'.$photo_id;
        if (file_exists($photo_file)) {
            $image = Image::make($photo_file);
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
            })
            // ->resizeCanvas(300, 220, 'top')
            // ->insert($exif_image, 'bottom')
            ;

            return $image->response();
        }
    }
    public function photoImportDisplay($folder_name, $file_name)
    {
        $dir = storage_path('photos/'.$folder_name);
        $photo_file = $dir.'/'.$file_name;
        if (file_exists($photo_file)) {
            $image = Image::make($photo_file);
            $mine_type = mime_content_type($photo_file);
            if ($image->width() > $image->height()) {
                $resize_width = 960;
                $resize_height = 540;
            } else {
                $resize_width = 540;
                $resize_height = 960;
            }
            $image->resize($resize_width, $resize_height, function ($constraint) {
            $constraint->aspectRatio();
        });

            return $image->response();
        } else {
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
        }
        $form = (object) [
            'action' => route('gallery_album_photo_import'),
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
            'content' => view('photo.import', [
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
