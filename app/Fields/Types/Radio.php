<?php

namespace App\Fields\Types;

use App\Fields\Types\Parameters\Items;
use App\Fields\Types\Parameters\Vertical;

class Radio extends Type
{
    use Vertical,
        Items;
    public function getContent()
    {
        $content = '';
        if (is_callable($this->_getContent)) {
            $content = call_user_func_array($this->_getContent, [$this->_items, $this->_value]);
        } else {
            if (isset($this->_items[$this->_value])) {
                $content = $this->_items[$this->_value];
            }
        }

        return $content;
    }
    public function getFormHtml()
    {
        return view('FieldsView::types.radio', [
            'label' => $this->getFormLabel(),
            'name' => $this->_name,
            'value' => $this->_value,
            'items' => $this->_items,
            'vertical' => $this->_vertical,
        ])->render();
    }
}
