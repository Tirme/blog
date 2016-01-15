<?php

namespace App\Fields;

use Field;

class TeamMember extends Model
{
    protected function register()
    {
        $name = Field::type('plan_text', [
            'label' => 'Name',
//                    'default' => 'Peter',
            'placeholder' => 'Your Name',
            'column' => 'Name',
            'index' => true,
//                    'required' => true,
            'rules' => ['required'],
        ]);
        $full_name = Field::type('full_name', [
            'label' => 'Full Name',
//                    'default' => 'Peter',
            'placeholder' => 'Your Name',
            'column' => 'Name',
            'index' => true,
//                    'required' => true,
            'rules' => ['required'],
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
                0 => 'Disabled',
                1 => 'Enabled',
            ],
        ]);
        $this->add('name', $name);
        $this->add('full_name', $full_name);
        $this->add('email', $email);
        $this->add('status', $status);
        $this->setFormAttributes([
            'class' => 'TemaMemberForm',
        ]);
    }
    protected function _onSave()
    {
    }
}
