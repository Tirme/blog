<?php

namespace App\Podm;

use Podm;

class AdminUser extends Model
{
    protected $admin_name = 'Admin User Management';
    protected $admin_description = '';
    protected function register()
    {
        $name = Podm::type('plan_text', [
            'label' => 'Name',
            'placeholder' => 'Your Name',
            'column' => 'Name',
            'index' => true,
            'rules' => ['required'],
        ]);
        $email = Podm::type('plan_text', [
            'label' => 'Email',
            'placeholder' => 'example@email.com',
            'index' => true,
            'rules' => ['required'],
        ]);
        $password = Podm::type('password', [
            'label' => 'Password',
            'placeholder' => '8~16 characters',
            'listable' => false,
            'rules' => ['required', 'confirmed'],
        ]);
        $enable = Podm::type('select', [
            'label' => 'Enable',
            'options' => [
                0 => 'Enabled',
                1 => 'Disabled',
            ],
        ]);
        $this
            ->add('name', $name)
            ->add('email', $email)
            ->add('password', $password)
            ->add('enable', $enable)
            ->setFormAttributes([
                'class' => 'AdminUserForm',
            ]);
    }
}
