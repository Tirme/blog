<?php

namespace App\Podm\Repositories\Podm;

use App\Podm\Repositories\Repository;
use App\Podm\Eloquence\PodmEloquent;

class PodmRepository extends Repository
{
    public function get($model_name, $id)
    {
        $query = with(new PodmEloquent())
            ->setCollection($model_name);
        $row = $query
            ->where('_id', $id)
            ->first();

        return $row;
    }
    public function has($model_name, $id)
    {
        return static::get($model_name, $id) !== null;
    }
    public function getList($model_name, $search = '', $per_page = 10)
    {
        $query = with(new PodmEloquent())
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
    public function getRows($model_name, $take = 10, $search = '')
    {
        $query = with(new PodmEloquent())
            ->setCollection($model_name);
        if (!empty($search)) {
            $query->where('name', 'like', '%'.$search.'%');
        }
        $rows = $query->skip(0)
            ->take($take)
            ->get();

        return $rows;
    }
    public function getAll($model_name)
    {
        $query = with(new PodmEloquent())
            ->setCollection($model_name);

        return $query->get();
    }
    public function store($model_name, $data)
    {
        $query = with(new PodmEloquent())
            ->setCollection($model_name);
        foreach ($data as $key => $value) {
            $query->$key = $value;
        }

        return $query->save();
    }
    public function update($model_name, $id, $data)
    {
        $query = with(new PodmEloquent())
            ->setCollection($model_name);

        return $query
            ->where('_id', $id)
            ->update($data);
    }
}
