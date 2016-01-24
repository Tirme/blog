<?php

namespace App\Podm;

use App\Podm\Exceptions\RegisterException as PodmRegisterException;

class Register
{
    protected $models = [];
    public function __construct()
    {
        $this->register(\App\Podm\Article::class, 'article');
        $this->register(\App\Podm\Topic::class, 'topic');
        $this->register(\App\Podm\Album::class, 'album');
        $this->register(\App\Podm\Photo::class, 'photo');
    }
    protected function register($class, $alias)
    {
        if (class_exists($class)) {
            $this->models[$alias] = $class;
        } else {
            throw new PodmRegisterException(sprintf('Model[%s] not exists.', $class));
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

        return view('PodmView::menu', [
            'models' => $models,
        ]);
    }
}
