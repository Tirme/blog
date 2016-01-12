<?php

namespace App\Fields\Types;

class Multiple extends Type
{
    protected $_fields = [];
    public function setFields(array $fields)
    {
        foreach ($fields as $field) {
            if (is_subclass_of($field, 'App\\Fields\\Types\\Type', false)) {
                $this->_fields[] = $field;
            }
        }
    }
    public function getContent()
    {
        $content = '';
        if (is_callable($this->_getContent)) {
            $content = call_user_func_array($this->_getContent, [$this->_value]);
        } else {
            $content = $this->_value;
        }

        return $content;
    }
    public function getFormHtml()
    {
        return view('FieldsView::types.multiple', [
            'label' => $this->getFormLabel(),
            'fields' => $this->_fields
        ])->render();
    }
}
