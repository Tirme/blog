<?php

namespace App\Fields\Repositories\Gallery;

use App\Fields\Repositories\Repository;
use App\Fields\Eloquence\Album as AlbumModel;

class AlbumRepository extends Repository
{
    public function getRows($rows = 10)
    {
        $collection = AlbumModel
            ::with('cover')
            ->where('available', '0')
            ->take($rows)
            ->get();
        return $collection;
    }
}
