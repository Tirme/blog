<?php

namespace App\Podm\Types\Parameters;

trait Placeholder
{
    protected $placeholder;
    public function setPlaceholder($placeholder)
    {
        $this->placeholder = $placeholder;
    }
}
