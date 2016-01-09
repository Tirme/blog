<?php

namespace App\Fields\Types\Parameters;

trait Placeholder
{
    protected $_placeholder;
    public function setPlaceholder($placeholder)
    {
        $this->_placeholder = $placeholder;
    }
}
