<?php

namespace App\Podm;

use Podm;

class Album extends Model
{
    protected $admin_name = 'Album Management';
    protected $admin_description = '';
    protected function register()
    {
        $name = Podm::type('plan_text', [
            'label' => 'Album Name',
            'placeholder' => 'Album Name',
            'column' => 'Name',
            'index' => true,
            'rules' => ['required'],
        ]);
        $summary = Podm::type('markdown', [
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
        $date = Podm::type('date', [
            'label' => 'Date',
            'column' => 'Date',
            'index' => true,
            'rules' => ['required'],
        ]);
        $available = Podm::type('select', [
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
                'class' => 'image',
                'link' => function ($row) {
                    return route('admin_gallery_album_photo_list', [
                        'album_id' => $row->_id,
                    ]);
                },
                'title' => 'Photos',
            ])
            ->addListAction([
                'class' => 'add_to_photos',
                'link' => function ($row) {
                    return route('admin_gallery_album_photo_form', [
                        'album_id' => $row->_id,
                    ]);
                },
                'title' => 'Add Photo',
            ])
            ->addListAction([
                'class' => 'collections',
                'link' => function ($row) {
                    return route('admin_gallery_album_photo_import_form', [
                        'date' => $row->date->value,
                    ]);
                },
                'title' => 'Import Photo',
            ]);
    }
}
