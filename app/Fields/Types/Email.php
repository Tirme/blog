<?php

namespace App\Fields\Types;

class Email extends Text
{
    protected $_rules = ['email'];
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
        return view('FieldsView::types.email', [
            'label' => $this->getFormLabel(),
            'name' => $this->name,
            'value' => $this->value,
            'placeholder' => $this->placeholder,
            'editable' => $this->mode() === 1 && !$this->editable() ? 'readonly=readonly' : '',
            'required' => $this->isRequired() ? 'required=required' : '',
        ])->render();
    }
}
