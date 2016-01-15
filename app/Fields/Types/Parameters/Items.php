<?php

namespace App\Fields\Types\Parameters;

trait Items
{
    protected $items = [];
    public function setItems(array $items)
    {
        $this->items = $items;

        return $this;
    }
}
