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
    public function getAll($search = [])
    {
        $query = $this->_query;
        $collection = collect();
        if (empty($search)) {
            $collection = $query->get();
        } else {

        }
        return $collection;
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
