<?php

namespace App\Fields\Types;

use App\Fields\Types\Parameters\Items;
use App\Fields\Types\Parameters\Vertical;

class Checkbox extends Type
{
    use Vertical,
            Items;
    public function getContent()
    {
        $content = [];
        if (is_callable($this->_getContent)) {
            $content = call_user_func_array($this->_getContent, [$this->_items, $this->_value]);
        } else {
            if (is_array($this->_value)) {
                foreach ($this->_value as $value) {
                    if (isset($this->_items[$value])) {
                        $content[] = $this->_items[$value];
                    }
                }
            }
        }

        return implode(', ', (array) $content);
    }
    public function getFormHtml()
    {
        return view('fields.types.checkbox', [
            'label' => $this->getFormLabel(),
            'name' => $this->_name,
            'values' => is_array($this->_value) ? $this->_value : [],
            'items' => $this->_items,
            'vertical' => $this->_vertical,
        ])->render();
    }
}
