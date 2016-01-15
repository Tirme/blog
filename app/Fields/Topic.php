<?php

namespace App\Fields;

use Field;

class Topic extends Model
{
    protected $admin_name = 'Topic Management';
    protected $admin_description = 'Blog topic';
    protected function register()
    {
        $name = Field::type('plan_text', [
            'label' => 'Name',
            'placeholder' => 'Subject',
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
            ->add('available', $available)
            ->setFormAttributes([
                'class' => 'TopicForm',
            ]);
    }
}
