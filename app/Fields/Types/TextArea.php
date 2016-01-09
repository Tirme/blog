<?php

namespace App\Fields\Types;

class TextArea extends Text
{
    public function getContent()
    {
        $content = '';
        if (is_callable($this->_getContent)) {
            $content = call_user_func_array($this->_getContent, [$this->_value]);
        } else {
            $content = $this->_value;
        }

        return $this->_value;
    }
    public function getFormHtml()
    {
        print_r($this);exit;
        return view('fields.types.textarea', [
            'label' => $this->getFormLabel(),
            'name' => $this->_name,
            'value' => $this->_value,
            'rows' => $this->_rows,
            'placeholder' => $this->_placeholder,
            'editable' => !$this->isEditable() ? 'readonly=readonly' : '',
            'required' => $this->isRequired() ? 'required=required' : '',
        ])->render();
    }
}
