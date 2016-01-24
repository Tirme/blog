<?php

namespace App\Podm\Types\Parameters;

trait Column
{
    protected $column_name = null;
    public function setColumn($column_name)
    {
        $this->column_name = $column_name;

        return $this;
    }
}
