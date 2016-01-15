<?php

namespace App\Fields;

use App\Fields\Exceptions\RegisterException as FieldRegisterException;

class Register
{
    protected $models = [];
    public function __construct()
    {
        $this->register(\App\Fields\Article::class, 'article');
        $this->register(\App\Fields\Topic::class, 'topic');
        $this->register(\App\Fields\Album::class, 'album');
        $this->register(\App\Fields\Photo::class, 'photo');
    }
    protected function register($class, $alias)
    {
        if (class_exists($class)) {
            $this->models[$alias] = $class;
        } else {
            throw new FieldRegisterException(sprintf('Model[%s] not exists.', $class));
        }
    }
    public function getModels()
    {
        return $this->models;
    }
    public function getMenu()
    {
        $models = [];
        foreach ($this->models as $model_name => $model) {
            if ($model::$menu_available) {
                $models[] = (object) [
                    'link' => route('model_list', [
                        'model_name' => $model_name,
                    ]),
                    'name' => $model_name,
                    'text' => class_basename($model),
                ];
            }
        }

        return view('FieldsView::menu', [
            'models' => $models,
        ]);
    }
}
