<?php

namespace App\Fields\Types;

class Photos extends Type
{
    public function getContent()
    {
        $content = '';
        if (is_callable($this->getContent)) {
            $content = call_user_func_array($this->getContent, [$this->value]);
        } else {
            $content = $this->value;
        }

        return $this->value;
    }
    public function getFormHtml()
    {
        return view('FieldsView::types.photos', [
            'label' => $this->getFormLabel(),
            'name' => $this->name,
            'value' => $this->value,
            'model_name' => 'aaa',
            'placeholder' => $this->placeholder,
            'editable' => !$this->isEditable() ? 'readonly=readonly' : '',
            'required' => $this->isRequired() ? 'required=required' : '',
        ])->render();
    }
}
