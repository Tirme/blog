<?php

namespace App\Podm\Types;

use App\Podm\Types\Parameters\Rows;

class Textarea extends Text
{
    use Rows;
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
        return view('PodmView::types.textarea', [
            'label' => $this->getFormLabel(),
            'name' => $this->name,
            'value' => $this->value,
            'rows' => $this->rows,
            'placeholder' => $this->placeholder,
            'editable' => !$this->isEditable() ? 'readonly=readonly' : '',
            'required' => $this->isRequired() ? 'required=required' : '',
        ])->render();
    }
}
