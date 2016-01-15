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
        if (is_callable($this->getContent)) {
            $content = call_user_func_array($this->getContent, [$this->items, $this->value]);
        } else {
            if (is_array($this->value)) {
                foreach ($this->value as $value) {
                    if (isset($this->items[$value])) {
                        $content[] = $this->items[$value];
                    }
                }
            }
        }

        return implode(', ', (array) $content);
    }
    public function getFormHtml()
    {
        return view('FieldsView::types.checkbox', [
            'label' => $this->getFormLabel(),
            'name' => $this->name,
            'values' => is_array($this->value) ? $this->value : [],
            'items' => $this->items,
            'vertical' => $this->vertical,
        ])->render();
    }
}
