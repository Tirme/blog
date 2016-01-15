<?php

namespace App\Fields;

use Field;

class Article extends Model
{
    protected $admin_name = 'Article Management';
    protected $admin_description = 'Blog article';
    protected function register()
    {
        $topic = Field::type('select', [
            'label' => 'Topic',
            'options' => function () {
                $options = [];
                $model = Field::getModel('Topic');
                $topics = $model->getAll();
                foreach ($topics as $topic) {
                    $options[$topic->getId()] = $topic->name;
                }

                return $options;
            },
            'rules' => ['required', 'fields:topic'],
        ]);
        $subject = Field::type('plan_text', [
            'label' => 'Subject',
            'placeholder' => 'Subject',
            'listable' => true,
            'editable' => false,
            'index' => true,
            'rules' => ['required'],
        ]);
        $content = Field::type('textarea', [
            'label' => 'Content',
            'rows' => 10,
            'placeholder' => 'Content',
            'listable' => true,
            'editable' => false,
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
        $this->add('topic', $topic);
        $this->add('subject', $subject);
        $this->add('content', $content);
        $this->add('available', $available);
        $this->setFormAttributes([
            'class' => 'ArticleForm',
        ]);
    }
}
