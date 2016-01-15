<?php

namespace App\Fields\Traits;

use RepositoryFactory;

trait TraitData
{
    public function getAll()
    {
        $repository = RepositoryFactory::create('Field\Field');
        $collection = $repository->getAll($this->getName());

        return $collection;
    }
}
