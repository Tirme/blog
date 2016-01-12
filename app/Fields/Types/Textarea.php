<?php

namespace App\Fields\Types;

use App\Fields\Types\Parameters\Rows;

class Textarea extends Text
{
    use Rows;
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
        return view('FieldsView::types.textarea', [
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
