<?php

namespace App\Fields;

use Field;

class Staff extends Model
{
    protected function _register()
    {
        $name = Field::type('plan_text', [
            'label' => 'Custoemr Name',
//                    'default' => 'Peter',
            'placeholder' => 'Your Name',
            'column' => 'Name',
            'index' => true,
//                    'required' => true,
            'rules' => ['required'],
            'content' => function ($value) {
//                tirme($value);
            return 'Name:'.$value;
            },
        ]);
        $email = Field::type('email', [
            'label' => 'E-mail',
//                    'default' => 'peter@gmail.com',
            'placeholder' => 'Your Email',
            'column' => 'E-mail',
            'editable' => false,
            'index' => true,
            'required' => true,
        ]);
        $status = Field::type('select', [
            'label' => 'Status',
            'column' => 'Status',
            'options' => [
                0 => '正職',
                1 => '派遣',
            ],
        ]);
        $this->_add('name', $name);
        $this->_add('email', $email);
        $this->_add('status', $status);
        $this->_setFormAttributes([
            'class' => 'CustomerForm',
        ]);
    }
    protected function _onSave()
    {
    }
}
