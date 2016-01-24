<?php

namespace App\Podm\Repositories;

abstract class Repository implements RepositoryInterface
{
    protected $result = null;
    protected $errors = null;
    public function hasErrors()
    {
        return $this->errors !== null;
    }
    public function getErrors()
    {
        return $this->errors;
    }
    public function getResult()
    {
        return $this->result;
    }
}
