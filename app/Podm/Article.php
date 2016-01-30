<?php

namespace App\Podm;

use Podm;

class Article extends Model
{
    protected $admin_name = 'Article Management';
    protected $admin_description = 'Blog article';
    protected function register()
    {
        $topic = Podm::type('select', [
            'label' => 'Topic',
            'options' => function () {
                $options = [];
                $model = Podm::getModel('Topic');
                $topics = $model->getAll();
                foreach ($topics as $topic) {
                    $options[$topic->getId()] = $topic->name;
                }

                return $options;
            },
            'rules' => ['required', 'podm_ref:topic'],
        ]);
        $subject = Podm::type('plan_text', [
            'label' => 'Subject',
            'placeholder' => 'Subject',
            'listable' => true,
            'index' => true,
            'rules' => ['required'],
        ]);
        $content = Podm::type('markdown', [
            'label' => 'Content',
            'rows' => 10,
            'placeholder' => 'Content',
            'listable' => true,
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
        $this->add('topic', $topic)
            ->add('subject', $subject)
            ->add('content', $content)
            ->add('available', $available)
            ->setFormAttributes([
                'class' => 'ArticleForm',
            ]);
    }
}
