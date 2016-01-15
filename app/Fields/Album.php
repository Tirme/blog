<?php

namespace App\Fields;

use Field;

class Album extends Model
{
    protected $admin_name = 'Album Management';
    protected $admin_description = '';
    protected function register()
    {
        $name = Field::type('plan_text', [
            'label' => 'Album Name',
            'placeholder' => 'Album Name',
            'column' => 'Name',
            'index' => true,
            'rules' => ['required'],
        ]);
        $date = Field::type('date', [
            'label' => 'Date',
            'column' => 'Date',
            'index' => true,
            'rules' => ['required'],
        ]);
        $available = Field::type('select', [
            'label' => 'Available',
            'options' => [
                0 => 'Available',
                1 => 'Not Available',
            ],
        ]);
        $this
            ->add('name', $name)
            ->add('date', $date)
            ->add('available', $available)
            ->setFormAttributes([
                'class' => 'AlbumForm',
            ])
            ->addListAction([
                'class' => 'glyphicon glyphicon-picture',
                'link' => route('gallery_album_photo_list', [
                    'album_id' => ':album_id',
                ]),
                'title' => 'Photos',
            ])
            ->addListAction([
                'class' => 'glyphicon glyphicon-plus',
                'link' => route('gallery_album_photo_form', [
                    'album_id' => ':album_id',
                ]),
                'title' => 'Add Photo',
            ]);
    }
}
