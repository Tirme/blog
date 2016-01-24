<?php

namespace App\Podm\Types;

use App\Podm\Types\Parameters\Rows;

class Markdown extends Text
{
    use Rows;
    public function getContent()
    {
        $content = '';
        if (is_callable($this->list_content)) {
            $content = call_user_func_array($this->list_content, [$this->value]);
        } else {
            $content = $this->value;
        }

        return $content;
    }
    public function getFormHtml()
    {
        return view('PodmView::types.markdown', [
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
