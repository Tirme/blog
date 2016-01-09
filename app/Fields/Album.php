<?php

namespace App\Fields;

use Field;

class Album extends Model
{
    protected $_admin_name = 'Album Management';
    protected $_admin_description = '';
    protected function _register()
    {
        $name = Field::type('plan_text', [
            'label' => 'Album Name',
//                    'default' => 'Peter',
            'placeholder' => 'Album Name',
            'column' => 'Name',
            'index' => true,
//                    'required' => true,
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
        $this->_add('name', $name);
        $this->_add('date', $date);
        $this->_add('available', $available);
        $this->_setFormAttributes([
            'class' => 'AlbumForm',
        ]);
    }
    protected function _onSave()
    {
    }
}
