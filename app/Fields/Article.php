<?php

namespace App\Fields;

use Field;

class Article extends Model
{
    protected $_admin_name = 'Article Management';
    protected $_admin_description = 'Blog article';
    protected function _register()
    {
        $subject = Field::type('plan_text', [
            'label' => 'Subject',
//                    'default' => 'Peter',
            'placeholder' => 'Subject',
            'listable' => true,
            'editable' => false,
            'index' => true,
            'rules' => ['required'],
        ]);
        $content = Field::type('textarea', [
            'label' => 'Content',
//                    'default' => 'Peter',
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
        $this->_add('subject', $subject);
        $this->_add('content', $content);
        $this->_add('available', $available);
        $this->_setFormAttributes([
            'class' => 'ArticleForm',
        ]);
    }
    protected function _onSave()
    {
    }
}
