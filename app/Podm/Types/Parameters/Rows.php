<?php

namespace App\Podm\Types\Parameters;

trait Rows
{
    protected $rows;
    public function setRows($rows)
    {
        $this->rows = $rows;
    }
}
