<?php

namespace App\Fields\Storage;

use Request;

class Storage
{
    protected $_driver = 'Mongo';
    protected $_query = null;
    public function __construct($name)
    {
        $this->_query = (new Mongo())->setCollection($name);
    }
    public function get($id)
    {
        $collection = $this->_query
            ->where('_id', $id)
            ->get();

        return $collection;
    }
    public function getList($per_page = 10)
    {
        $search = Request::query('search', '');
        $query = $this->_query;
        if (empty($search)) {
            $pagination = $this->_query
                ->paginate($per_page);
            $pagination->hack_items = $pagination->getCollection();
        } else {
            $pagination = $this->_query
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
    public function insert($data)
    {
        foreach ($data as $key => $value) {
            $this->_query->$key = $value;
        }

        return $this->_query
            ->save();
    }
    public function update($id, $data)
    {
        return $this->_query
            ->where('_id', $id)
            ->update($data);
    }
}
