<?php

namespace App\Fields\Types;

use App\Fields\Types\Parameters\Options;

class Select extends Type
{
    use Options;
    public function getContent()
    {
        $content = [];
        if (is_callable($this->_getContent)) {
            $content = call_user_func_array($this->_getContent, [$this->_options, $this->_value]);
        } else {
            if (isset($this->_options[$this->_value])) {
                $content[] = $this->_options[$this->_value];
            }
        }

        return implode(', ', (array) $content);
    }
    public function getFormHtml()
    {
        return view('FieldsView::types.select', [
            'label' => $this->getFormLabel(),
            'name' => $this->_name,
            'selected_value' => $this->_value,
            'options' => $this->_options,
        ])->render();
    }
}
