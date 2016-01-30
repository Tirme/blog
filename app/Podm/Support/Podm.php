<?php

namespace App\Podm\Support;

use App\Podm\Register as PodmRegister;
use App\Podm\Model as Model;
use App\Podm\Storage\Storage as PodmStorage;
use App\Podm\Labels\Label as PodmLabel;
use App\Podm\Exceptions\TypeException;
use App\Podm\Exceptions\RegisterException;
use Illuminate\Contracts\Encryption\DecryptException;
use Crypt;
use RepositoryFactory;

class Podm {

    protected $models = [];

    public function __construct() {
        static::register();
    }

    protected function register() {
        $models = config('podm.models', []);
        foreach ($models as $model) {
            list($class, $alias) = $model;
            if (class_exists($class)) {
                $this->models[$alias] = $class;
            } else {
                throw new RegisterException(sprintf('Model[%s] not exists.', $class));
            }
        }
    }

    public function getModels() {
        return $this->models;
    }

    public function getModel($name, array $data = []) {
        $model = null;
        $model_name = snake_case($name);
        if (isset($this->models[$model_name])) {
            $model = new $this->models[$model_name]($data);
        } else {
            throw new PodmEloquentException('Model[%s(%s)] not exists');
        }

        return $model;
    }

    public function getModelById($name, $id) {
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

    public function getMenuLinks() {
        $menu_links = [];
        $models = $this->getModels();
        foreach ($models as $model_name => $model) {
            $menu_links[] = [
                'link' => route('model_list', [
                    'model_name' => $model_name
                ]),
                'text' => class_basename($model)
            ];
        }
        return $menu_links;
    }

    public function label($label = null) {
        return new PodmLabel($label);
    }

    public function type($type = 'text', array $params = []) {
        $class_name = '\\App\\Podm\\Types\\' . studly_case($type);
        if (class_exists($class_name)) {
            return new $class_name($params);
        } else {
            throw new TypeException(sprintf('Field type[%s] not found', $type));
        }
    }

    public function storage($name) {
        return new PodmStorage($name);
    }

    public function cryptHash(array $data) {
        $string = serialize($data);

        return Crypt::encrypt($string);
    }

    public function decryptHash($hash) {
        try {
            $decrypted = Crypt::decrypt($hash);

            return unserialize($decrypted);
        } catch (DecryptException $e) {
            return false;
        }
    }

    public function listLink($link, $row) {
        $result = '';
        if (is_string($link)) {
            $result = $link;
        } elseif (is_callable($link)) {
            $result = $link($row);
        }

        return $result;
    }

}
