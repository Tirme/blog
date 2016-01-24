<?php

namespace App\Podm;

use Podm;

class Customer extends Model
{
    protected function _register()
    {
        $name = Podm::type('plan_text', [
            'label' => 'Custoemr Name',
//                    'default' => 'Peter',
            'placeholder' => 'Your Name',
            'column' => 'Name',
            'index' => true,
//                    'required' => true,
            'rules' => ['required'],
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
                0 => 'Disabled',
                1 => 'Enabled',
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
