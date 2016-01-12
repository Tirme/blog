<?php

namespace App\Fields;

use App\Fields\Exceptions\RegisterException as FieldRegisterException;

class Register
{
    protected $_models = [];
    public function __construct()
    {
        $this->_register(\App\Fields\Article::class, 'article');
        $this->_register(\App\Fields\Album::class, 'album');
        $this->_register(\App\Fields\Photo::class, 'photo');
    }
    protected function _register($class, $alias)
    {
        if (class_exists($class)) {
            $this->_models[$alias] = $class;
        } else {
            throw new FieldRegisterException(sprintf('Model[%s] not exists.', $class));
        }
    }
    public function getModels()
    {
        return $this->_models;
    }
    public function getMenu()
    {
        $models = [];
        foreach ($this->_models as $model_name => $model) {
            if ($model::$_menu_available) {
                $models[] = (object) [
                    'link' => route('model_list', [
                        'model_name' => $model_name,
                    ]),
                    'name' => $model_name,
                    'text' => class_basename($model),
                ];
            }
        }

        return view('fields.menu', [
            'models' => $models,
        ]);
    }
}
