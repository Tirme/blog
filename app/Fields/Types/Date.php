<?php

namespace App\Fields\Types;

class Date extends Text
{
    protected $_rules = ['date'];
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
        return view('FieldsView::types.date', [
            'label' => $this->getFormLabel(),
            'name' => $this->_name,
            'value' => $this->_value,
            'placeholder' => $this->_placeholder,
            'editable' => $this->mode() === 1 && !$this->editable() ? 'readonly=readonly' : '',
            'required' => $this->isRequired() ? 'required=required' : '',
        ])->render();
    }
}
