<?php

namespace App\Fields\Support;

use App\Fields\Register as FieldRegister;
use App\Fields\Storage\Storage as FieldStorage;
use App\Fields\Labels\Label as FieldLabel;
use App\Fields\Exceptions\ModelException as FieldTypeException;
use App\Fields\Exceptions\TypeException as FieldModelException;
use Illuminate\Contracts\Encryption\DecryptException;
use Crypt;
use RepositoryFactory;

class Field
{
    public function getModels()
    {
        return (new FieldRegister())->getModels();
    }
    public function getModel($name, array $data = [])
    {
        $model = null;
        $model_name = snake_case($name);
        $models = self::getModels();
        if (isset($models[$model_name])) {
            $model = new $models[$model_name]($data);
        } else {
            throw new FieldModelException('Model[%s(%s)] not exists');
        }

        return $model;
    }
    public function getModelById($name, $id)
    {
        $model = null;
        $model_name = snake_case($name);
        $models = self::getModels();
        if (isset($models[$model_name])) {
            $repository = RepositoryFactory::create('Field\Field');
            $row = $repository->get($model_name, $id);
            if ($row) {
                $model = new $models[$model_name]($row->toArray());
            }
        } else {
            throw new FieldModelException(
                sprintf('Model[%s] not exists', $model_name)
            );
        }

        return $model;
    }
    public function getMenu()
    {
        return (new FieldRegister())->getMenu();
    }
    public function label($label = null)
    {
        return new FieldLabel($label);
    }
    public function type($type = 'text', array $params = [])
    {
        $class_name = '\\App\\Fields\\Types\\'.studly_case($type);
        if (class_exists($class_name)) {
            return new $class_name($params);
        } else {
            throw new FieldTypeException(sprintf('Field type[%s] not found', $type));
        }
    }
    public function storage($name)
    {
        return new FieldStorage($name);
    }
    public function cryptHash(array $data)
    {
        $string = serialize($data);

        return Crypt::encrypt($string);
    }
    public function decryptHash($hash)
    {
        try {
            $decrypted = Crypt::decrypt($hash);

            return unserialize($decrypted);
        } catch (DecryptException $e) {
            return false;
        }
    }
    public function formatLink($link, array $params = [])
    {
        return strtr($link, $params);
    }
}
