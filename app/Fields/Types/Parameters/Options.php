<?php

namespace App\Fields\Types\Parameters;

trait Options
{
    protected $_options = [];
    public function setOptions(array $options)
    {
        $this->_options = $options;

        return $this;
    }
}
