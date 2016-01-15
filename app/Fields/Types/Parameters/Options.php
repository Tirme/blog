<?php

namespace App\Fields\Types\Parameters;

trait Options
{
    protected $options = [];
    public function setOptions($options)
    {
        if (is_array($options)) {
            $this->options = $options;
        } elseif (is_callable($options)) {
            $this->options = $options();
        }

        return $this;
    }
}
