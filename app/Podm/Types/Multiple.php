<?php

namespace App\Podm\Types;

class Multiple extends Type
{
    protected $_fields = [];
    public function setFields(array $fields)
    {
        foreach ($fields as $field) {
            if (is_subclass_of($field, 'App\\Podm\\Types\\Type', false)) {
                $this->fields[] = $field;
            }
        }
    }
    public function getContent()
    {
        $content = '';
        if (is_callable($this->getContent)) {
            $content = call_user_func_array($this->getContent, [$this->value]);
        } else {
            $content = $this->value;
        }

        return $content;
    }
    public function getFormHtml()
    {
        return view('PodmView::types.multiple', [
            'label' => $this->getFormLabel(),
            'fields' => $this->fields
        ])->render();
    }
}
