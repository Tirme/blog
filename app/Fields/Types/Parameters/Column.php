<?php

namespace App\Fields\Types\Parameters;

trait Column
{
    protected $_column_name = null;
    public function setColumn($column_name)
    {
        $this->_column_name = $column_name;

        return $this;
    }
}
