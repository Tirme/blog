<?php

namespace App\Http\Controllers\Gallery\Admin;

use App\Http\Controllers\Controller;
use Field;
use RepositoryFactory;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use App\Http\Requests\Gallery\PhotoImportRequest;

class AlbumController extends Controller
{
    public function photoList($album_id)
    {
        $album = with(RepositoryFactory::create('Gallery\Album'))
            ->get($album_id);
        if ($album === null) {
            return redirect()->route('model_list', [
                'model_name' => 'album',
            ]);
        }
        $albums = with(RepositoryFactory::create('Gallery\Album'))
            ->getAll();
        $photos = with(RepositoryFactory::create('Gallery\Photo'))
            ->getList($album_id, 12);
        $form = (object) [
            'action' => route('admin_gallery_album_photo_list_update', [
                'album_id' => $album_id,
            ]),
        ];
        // @todo 只留一層view
        return view('FieldsView::fields', [
            'menu' => Field::getMenu(),
            'content' => view('gallery.photo.admin.list', [
                'album' => $album,
                'albums' => $albums,
                'photos' => $photos,
                'form' => $form,
            ]),
        ]);
    }
    public function photoListUpdate(Request $request, $album_id)
    {
        $album = with(RepositoryFactory::create('Gallery\Album'))
            ->get($album_id);
        if ($album === null) {
            return redirect()->route('model_list', [
                'model_name' => 'album',
            ]);
        }
        $photos = $request->get('photos', []);
        $repository = RepositoryFactory::create('Gallery\Photo');
        foreach ($photos as $photo_id => $photo) {
            $photo['album_id'] = empty($photo['album_id']) ? null : $photo['album_id'];
            $repository->update($photo_id, [
                'album_id' => $photo['album_id'],
                'summary' => $photo['summary']
            ]);
        }
        return redirect()->route('admin_gallery_album_photo_list', [
            'album_id' => $album_id,
        ]);
    }
    public function photoDisplay($album_id, $photo_id, $size)
    {
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
    public function photoUploadForm($album_id)
    {
        echo '暫停開放';
        // $album = with(RepositoryFactory::create('Field\Field'))->get('album', $album_id);
        // if ($album === null) {
        //     return redirect('/');
        // }
        // $form = (object) [
        //     'action' => route('model_store', [
        //         'model_name' => 'photo',
        //     ]),
        //     'album_id' => $album_id,
        //     'photo_upload' => Field::type('photos', [
        //         'label' => 'Upload Photos',
        //     ]),
        //     'redirect' => [
        //         'success' => route('admin_gallery_album_photo_list', $album_id),
        //         'error' => route('admin_gallery_album_photo_form', $album_id),
        //     ],
        //     'hash' => Field::cryptHash([
        //         'model_name' => 'photo',
        //     ]),
        // ];
        //
        // return view('FieldsView::fields', [
        //     'menu' => Field::getMenu(),
        //     'content' => view('gallery.photo.admin.form', [
        //         'form' => $form,
        //         'errors' => session('errors', []),
        //     ]),
        // ]);
    }
    public function photoImportDisplay($photo_id, $size)
    {
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
    public function photoImportForm(Request $request, $date)
    {
        $repository = RepositoryFactory::create('Gallery\Photo');
        $photos = $repository->queryForImport($date, 48);
        $form = (object) [
            'action' => route('admin_gallery_album_photo_import'),
            'album' => Field::type('select', [
                'label' => '選擇相簿',
                'column' => 'Name',
                'name' => 'album_id',
                'options' => function () {
                    $options = [];
                    $albums = with(RepositoryFactory::create('Gallery\Album'))
                        ->getAll();
                    $options[] = 'Select Album';
                    foreach ($albums as $album) {
                        $options[$album->getId()] = $album->name.' - '.$album->date;
                    }

                    return $options;
                },
            ]),
        ];
        // @todo 調整成只做一層view
        return view('FieldsView::fields', [
            'menu' => Field::getMenu(),
            'content' => view('gallery.photo.admin.import', [
                'form' => $form,
                'errors' => session('errors', null),
                'date' => $date,
                'photos' => $photos,
            ]),
        ]);
    }
    public function photoImport(PhotoImportRequest $request)
    {
        $album_id = $request->get('album_id', null);
        $date = $request->get('date', null);
        $collection = collect($request->get('photos', []));
        $photos = $collection->filter(function ($item) {
            return isset($item['import']) && $item['import'] === '1';
        });
        $repository = RepositoryFactory::create('Gallery\Photo');
        foreach ($photos as $photo_id => $photo) {
            $repository->update($photo_id, [
                'album_id' => $album_id,
            ]);
        }

        return redirect()
            ->route('admin_gallery_album_photo_import_form', [
                'date' => $date,
            ]);
    }
}
