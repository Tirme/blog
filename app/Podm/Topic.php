<?php

namespace App\Podm;

use Podm;

class Topic extends Model
{
    protected $admin_name = 'Topic Management';
    protected $admin_description = 'Blog topic';
    protected function register()
    {
        $name = Podm::type('plan_text', [
            'label' => 'Name',
            'placeholder' => 'Subject',
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
            ->add('available', $available)
            ->setFormAttributes([
                'class' => 'TopicForm',
            ]);
    }
}
