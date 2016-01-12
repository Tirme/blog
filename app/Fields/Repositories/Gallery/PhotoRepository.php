<?php

namespace App\Fields\Repositories\Gallery;

use App\Fields\Repositories\Repository;
use App\Fields\Storage\FieldModel;

class PhotoRepository extends Repository
{
    public function getList()
    {
        $model = new FieldModel();
        $model->setCollection('Photo');
        $data = $model->get();
        return $data;
    }
}
