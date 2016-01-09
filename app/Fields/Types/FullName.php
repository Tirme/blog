<?php

namespace App\Fields\Types;

class FullName extends Text
{
    protected $_rules = [];
    public function getContent()
    {
    }
    public function getFormHtml()
    {
        return view('fields.types.full_name', [
            'name' => $this->_name,
            'value' => $this->_value,
            'placeholder' => $this->_placeholder,
        ])->render();
    }
}
