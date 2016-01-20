<?php

namespace App\Fields\Repositories\Gallery;

use App\Fields\Repositories\Repository;
use App\Fields\Storage\FieldModel;

class PhotoRepository extends Repository
{
    public function getList($album_id)
    {
        $model = new FieldModel();
        $model->setCollection('Photo');
        $collection = $model
            ->where('album_id', $album_id)
            ->get();

        return $collection;
    }
    public function getAlbumCover($album_id)
    {
        $model = new FieldModel();
        $model->setCollection('Photo');
        $row = $model->where('album_id', $album_id)
            ->take(1);

        return $row;
    }
}
