<?php

namespace App\Fields\Repositories\Gallery;

use App\Fields\Repositories\Repository;
use App\Fields\Eloquence\Album as AlbumModel;

class AlbumRepository extends Repository
{
    public function get($id) {
        $album = AlbumModel
            ::where('_id', $id)
            ->first();
        return $album;
    }
    public function getRows($rows = 10)
    {
        $collection = AlbumModel
            ::with('cover')
            ->where('available', '0')
            ->take($rows)
            ->get();
        return $collection;
    }
    public function getAll()
    {
        $collection = AlbumModel
            ::all();
        return $collection;
    }
}
