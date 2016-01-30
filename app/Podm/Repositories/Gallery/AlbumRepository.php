<?php

namespace App\Podm\Repositories\Gallery;

use App\Podm\Repositories\Repository;
use App\Podm\Eloquence\Album as AlbumModel;

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
            ::with('cover', 'photos')
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
