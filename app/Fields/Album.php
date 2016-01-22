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
        $summary = Field::type('markdown', [
            'label' => 'Summary',
            'list_content' => function ($content) {
                return mb_substr($content, 0, 10);
            },
            'rows' => 10,
            'placeholder' => 'Summary',
            'listable' => false,
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
            ->add('summary', $summary)
            ->add('date', $date)
            ->add('available', $available)
            ->setFormAttributes([
                'class' => 'AlbumForm',
            ])
            ->addListAction([
                'class' => 'glyphicon glyphicon-picture',
                'link' => function ($row) {
                    return route('admin_gallery_album_photo_list', [
                        'album_id' => $row->_id,
                    ]);
                },
                'title' => 'Photos',
            ])
            ->addListAction([
                'class' => 'glyphicon glyphicon-plus',
                'link' => function ($row) {
                    return route('admin_gallery_album_photo_form', [
                        'album_id' => $row->_id,
                    ]);
                },
                'title' => 'Add Photo',
            ])
            ->addListAction([
                'class' => 'glyphicon glyphicon-import',
                'link' => function ($row) {
                    return route('admin_gallery_album_photo_import_form', [
                        'date' => $row->date->value,
                    ]);
                },
                'title' => 'Import Photo',
            ]);
    }
}
