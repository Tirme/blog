<?php

namespace App\Fields\Eloquence;

class Album extends FieldModel
{
    protected $collection = 'Albums';
    public function cover()
    {
        return $this->hasOne('Photo', 'album_id', '_id');
    }
}
