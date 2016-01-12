<?php

namespace App\Fields\Storage;

use Jenssegers\Mongodb\Model;

class FieldModel extends Model
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
