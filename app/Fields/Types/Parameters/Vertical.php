<?php

namespace App\Fields\Types\Parameters;

trait Vertical
{
    protected $_vertical = false;
    public function setOptions($vertical)
    {
        $this->_vertical = $vertical === true;

        return $this;
    }
}
