<?php

namespace App\Fields\Support;

use App\Fields\Repositories\RepositoryInterface;
use App\Fields\Exceptions\RepositoryFactoryException;

class RepositoryFactory
{
    protected $_namespace = 'App\\Fields\Repositories';
    public function create($name = null)
    {
        $repository_name = substr($name, strrpos($name, '\\') + 1);
        $module_name = substr($name, 0, strrpos($name, '\\'));
        $factory_name = studly_case(substr($module_name, strrpos($module_name, '\\') + 1));
        $factory_class = sprintf('%s\\%s\\%sRepositoryFactory', $this->_namespace, $module_name, $factory_name);
        if (class_exists($factory_class)) {
            $factory = new $factory_class();
            if ($factory instanceof FactoryInterface) {
                return $factory->create($repository_name);
            } else {
                throw new RepositoryFactoryException($factory_class.' is not instance of FactoryInterface');
            }
        } else {
            $repository_class = sprintf('%s\\%s\\%sRepository', $this->_namespace, $module_name, $repository_name);
            if (class_exists($repository_class)) {
                $repository = new $repository_class();
                if ($repository instanceof RepositoryInterface) {
                    return $repository;
                } else {
                    throw new RepositoryFactoryException($repository_class.' is not instance of RepositoryInterface');
                }
            }
        }
    }
}
