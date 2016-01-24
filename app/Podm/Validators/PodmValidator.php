<?php

namespace App\Podm\Validators;

use RepositoryFactory;

class PodmValidator
{
    public function validateRef($attribute, $id, $parameters, $validator)
    {
        $valid = false;
        list($model_name) = $parameters;
        $repository = RepositoryFactory::create('Podm\Podm');
        if ($repository->has($model_name, $id)) {
            $valid = true;
        }
        return $valid;
    }
}
