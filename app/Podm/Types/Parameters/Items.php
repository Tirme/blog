<?php

namespace App\Podm\Types\Parameters;

trait Items
{
    protected $items = [];
    public function setItems(array $items)
    {
        $this->items = $items;

        return $this;
    }
}
