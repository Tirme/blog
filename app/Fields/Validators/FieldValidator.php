<?php

namespace App\Fields\Validators;

use RepositoryFactory;

class FieldValidator
{
    public function validateRef($attribute, $id, $parameters, $validator)
    {
        $valid = false;
        list($model_name) = $parameters;
        $repository = RepositoryFactory::create('Field\Field');
        if ($repository->has($model_name, $id)) {
            $valid = true;
        }
        return $valid;
    }
}
