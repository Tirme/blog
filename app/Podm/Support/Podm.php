<?php

namespace App\Podm\Support;

use App\Podm\Register as PodmRegister;
use App\Podm\Storage\Storage as PodmStorage;
use App\Podm\Labels\Label as PodmLabel;
use App\Podm\Exceptions\PdomEloquentException;
use App\Podm\Exceptions\TypeException;
use Illuminate\Contracts\Encryption\DecryptException;
use Crypt;
use RepositoryFactory;
use Closure;

class Podm
{
    public function getModels()
    {
        return (new PodmRegister())->getModels();
    }
    public function getModel($name, array $data = [])
    {
        $model = null;
        $model_name = snake_case($name);
        $models = self::getModels();
        if (isset($models[$model_name])) {
            $model = new $models[$model_name]($data);
        } else {
            throw new PodmEloquentException('Model[%s(%s)] not exists');
        }

        return $model;
    }
    public function getModelById($name, $id)
    {
        $model = null;
        $model_name = snake_case($name);
        $models = self::getModels();
        if (isset($models[$model_name])) {
            $repository = RepositoryFactory::create('Podm\Podm');
            $row = $repository->get($model_name, $id);
            if ($row) {
                $model = new $models[$model_name]($row->toArray());
            }
        } else {
            throw new PodmEloquentException(
                sprintf('Model[%s] not exists', $model_name)
            );
        }

        return $model;
    }
    public function getMenu()
    {
        return (new PodmRegister())->getMenu();
    }
    public function label($label = null)
    {
        return new PodmLabel($label);
    }
    public function type($type = 'text', array $params = [])
    {
        $class_name = '\\App\\Podm\\Types\\'.studly_case($type);
        if (class_exists($class_name)) {
            return new $class_name($params);
        } else {
            throw new TypeException(sprintf('Field type[%s] not found', $type));
        }
    }
    public function storage($name)
    {
        return new PodmStorage($name);
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
    public function listLink($link, $row)
    {
        $result = '';
        if (is_string($link)) {
            $result = $link;
        } else if (is_callable($link)) {
            $result = $link($row);
        }
        return $result;
    }
}
