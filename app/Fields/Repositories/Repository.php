<?php

namespace App\Fields\Repositories;

abstract class Repository implements RepositoryInterface
{
    protected $_result = null;
    protected $_errors = null;
    public function hasErrors()
    {
        return $this->_errors !== null;
    }
    public function getErrors()
    {
        return $this->_errors;
    }
    public function getResult()
    {
        return $this->_result;
    }
}
