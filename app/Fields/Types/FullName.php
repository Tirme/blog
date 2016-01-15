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
        return view('FieldsView::types.full_name', [
            'name' => $this->name,
            'value' => $this->value,
            'placeholder' => $this->placeholder,
        ])->render();
    }
}
