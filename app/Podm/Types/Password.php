<?php

namespace App\Podm\Types;

class Password extends Text
{
    protected $_rules = [];
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
        return view('PodmView::types.password', [
            'label' => $this->getFormLabel(),
            'name' => $this->name,
            'value' => $this->value,
            'placeholder' => $this->placeholder,
            'editable' => $this->mode() === 1 && !$this->editable() ? 'readonly=readonly' : '',
            'required' => $this->isRequired() ? 'required=required' : '',
        ])->render();
    }
    public function preStore($value) {
        return md5($value);
    }
    public function preUpdate($value) {
        return md5($value);
    }
}
