<?php

namespace App\Podm\Storage;

use Jenssegers\Mongodb\Model;

class PodmModel extends Model
{
    public $incrementing = false;
    protected $connection = 'mongodb';
    protected $collection = 'unknow';
    public function setCollection($name)
    {
        $this->collection = studly_case(str_plural($name));

        return $this;
    }
    public function getId()
    {
        return $this->_id;
    }
}
