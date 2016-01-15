<?php

namespace App\Fields\Types\Parameters;

trait Vertical
{
    protected $vertical = false;
    public function setOptions($vertical)
    {
        $this->vertical = $vertical === true;

        return $this;
    }
}
