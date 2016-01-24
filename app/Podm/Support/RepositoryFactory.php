<?php

namespace App\Podm\Support;

use App\Podm\Repositories\RepositoryInterface;
use App\Podm\Exceptions\RepositoryFactoryException;

class RepositoryFactory
{
    protected $namespace = 'App\\Podm\Repositories';
    public function create($name = null)
    {
        $repository_name = substr($name, strrpos($name, '\\') + 1);
        $module_name = substr($name, 0, strrpos($name, '\\'));
        $factory_name = studly_case(substr($module_name, strrpos($module_name, '\\') + 1));
        $factory_class = sprintf('%s\\%s\\%sRepositoryFactory', $this->namespace, $module_name, $factory_name);
        if (class_exists($factory_class)) {
            $factory = new $factory_class();
            if ($factory instanceof FactoryInterface) {
                return $factory->create($repository_name);
            } else {
                throw new RepositoryFactoryException($factory_class.' is not instance of FactoryInterface');
            }
        } else {
            $repository_class = sprintf('%s\\%s\\%sRepository', $this->namespace, $module_name, $repository_name);
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
