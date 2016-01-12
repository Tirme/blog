<?php

namespace App\Fields\Types\Parameters;

trait Options
{
    protected $_options = [];
    public function setOptions($options)
    {
        if (is_array($options)) {
            $this->_options = $options;
        } elseif (is_callable($options)) {
            $this->_options = $options();
        }

        return $this;
    }
}
