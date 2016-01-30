<?php

namespace App\Podm\Eloquence;

class Album extends PodmEloquent
{
    protected $collection = 'Albums';
    public function cover()
    {
        return $this->hasOne('Photo', 'album_id', '_id');
    }
    public function photos() {
        return $this->hasMany('Photo', 'album_id', '_id');
    }
}