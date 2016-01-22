<?php

namespace App\Fields\Eloquence;

class Photo extends FieldModel
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
