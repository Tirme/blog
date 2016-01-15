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
        if (is_callable($this->getContent)) {
            $content = call_user_func_array($this->getContent, [$this->items, $this->value]);
        } else {
            if (isset($this->items[$this->value])) {
                $content = $this->items[$this->value];
            }
        }

        return $content;
    }
    public function getFormHtml()
    {
        return view('FieldsView::types.radio', [
            'label' => $this->getFormLabel(),
            'name' => $this->name,
            'value' => $this->value,
            'items' => $this->items,
            'vertical' => $this->vertical,
        ])->render();
    }
}
