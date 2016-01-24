<?php

namespace App\Podm;

use Podm;

class Staff extends Model
{
    protected function register()
    {
        $name = Podm::type('plan_text', [
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
        $email = Podm::type('email', [
            'label' => 'E-mail',
//                    'default' => 'peter@gmail.com',
            'placeholder' => 'Your Email',
            'column' => 'E-mail',
            'editable' => false,
            'index' => true,
            'required' => true,
        ]);
        $status = Podm::type('select', [
            'label' => 'Status',
            'column' => 'Status',
            'options' => [
                0 => '正職',
                1 => '派遣',
            ],
        ]);
        $this->add('name', $name);
        $this->add('email', $email);
        $this->add('status', $status);
        $this->setFormAttributes([
            'class' => 'CustomerForm',
        ]);
    }
    protected function _onSave()
    {
    }
}
