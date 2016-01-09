<?php

namespace App\Fields\Types\Parameters;

trait Items
{
    protected $_items = [];
    public function setItems(array $items)
    {
        $this->_items = $items;

        return $this;
    }
}
