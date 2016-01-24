<?php

namespace App\Podm\Storage;

use Request;

class Storage
{
    protected $driver = 'Mongo';
    protected $query = null;
    public function __construct($name)
    {
        $this->query = (new Mongo())->setCollection($name);
    }
    public function get($id)
    {
        $collection = $this->query
            ->where('_id', $id)
            ->get();

        return $collection;
    }
    public function getAll($search = [])
    {
        $query = $this->query;
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
            $this->query->$key = $value;
        }

        return $this->query
            ->save();
    }
    public function update($id, $data)
    {
        return $this->query
            ->where('_id', $id)
            ->update($data);
    }
}
