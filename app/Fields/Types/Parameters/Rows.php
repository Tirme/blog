<?php

namespace App\Fields\Types\Parameters;

trait Rows
{
    protected $_rows;
    public function setRows($rows)
    {
        $this->_rows = $rows;
    }
}
