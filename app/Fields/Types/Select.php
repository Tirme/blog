<?php

namespace App\Fields\Types;

use App\Fields\Types\Parameters\Options;

class Select extends Type
{
    use Options;
    public function getContent()
    {
        $content = [];
        if (is_callable($this->getContent)) {
            $content = call_user_func_array($this->getContent, [$this->options, $this->value]);
        } else {
            if (isset($this->options[$this->value])) {
                $content[] = $this->options[$this->value];
            }
        }

        return implode(', ', (array) $content);
    }
    public function getFormHtml()
    {
        return view('FieldsView::types.select', [
            'label' => $this->getFormLabel(),
            'name' => $this->name,
            'selected_value' => $this->value,
            'options' => $this->options,
        ])->render();
    }
}
