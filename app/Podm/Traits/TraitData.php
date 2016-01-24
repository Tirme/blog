<?php

namespace App\Podm\Traits;

use RepositoryFactory;

trait TraitData
{
    public function getAll()
    {
        $repository = RepositoryFactory::create('Podm\Podm');
        $collection = $repository->getAll($this->getName());

        return $collection;
    }
}
