<?php

namespace App\Podm\Eloquence;

use Jenssegers\Mongodb\Model as Eloquent;

class PodmEloquent extends Eloquent
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
    public function hasOne($related, $foreignKey = null, $localKey = null)
    {
        $related = __NAMESPACE__.'\\'.$related;

        return parent::hasOne($related, $foreignKey, $localKey);
    }
    public function hasMany($related, $foreignKey = null, $localKey = null)
    {
        $related = __NAMESPACE__.'\\'.$related;

        return parent::hasMany($related, $foreignKey, $localKey);
    }
}
