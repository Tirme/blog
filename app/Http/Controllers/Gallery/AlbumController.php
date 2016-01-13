<?php

namespace App\Http\Controllers\Gallery;

use App\Http\Controllers\Controller;
use Field;
use RepositoryFactory;

class AlbumController extends Controller
{
    public function photoList($album_id)
    {
        $repository = RepositoryFactory::create('Gallery\Photo');
        $collection = $repository->getList();
        return view('admin', [
            'menu' => Field::getMenu(),
            'content' => view('photo.list')
        ]);
        // return response()->json(['photos' => $collection]);
    }
    public function photoUploadForm($album_id)
    {
        dd($album_id);
    }
}
