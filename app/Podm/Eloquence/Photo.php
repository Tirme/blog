<?php

namespace App\Podm\Eloquence;

class Photo extends PodmEloquent
{
    protected $collection = 'Photos';
    protected $fillable = [
        'date',
        'album_id',
        'file_name',
        'summary',
        'make',
        'model',
        'shot',
        'f_number',
        'exposure_time',
        'focal_length',
        'iso',
        'width',
        'height',
        'exif'
    ];
}
