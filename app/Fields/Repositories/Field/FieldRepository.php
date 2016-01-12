<?php

namespace App\Fields\Repositories\Field;

use App\Fields\Repositories\Repository;
use App\Fields\Storage\FieldModel;
use Request;

class FieldRepository extends Repository
{
    public function get($model_name, $id)
    {
        $query = with(new FieldModel())
            ->setCollection($model_name);
        $collection = $query
            ->where('_id', $id)
            ->get();

        return $collection;
    }
    public function getList($model_name, $search = '', $per_page = 20)
    {
        $query = with(new FieldModel())
            ->setCollection($model_name);
        if (empty($search)) {
            $pagination = $query
                ->paginate($per_page);
            $pagination->hack_items = $pagination->getCollection();
        } else {
            $pagination = $query
                ->where('name', 'like', '%'.$search.'%')
                ->paginate($per_page);
            $collection = $query
                ->where('name', 'like', '%'.$search.'%')
                ->skip(($pagination->currentPage() - 1) * $pagination->perPage())
                ->take($pagination->perPage())
                ->get();
            $pagination->hack_items = $collection;
            $pagination->appends(['search' => $search]);
        }

        return $pagination;
    }
    public function all($model_name)
    {
    }
}