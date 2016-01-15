<?php

namespace App\Fields;

use Field;
use Validator;
use RepositoryFactory;

class Photo extends Model
{
    public static $menu_available = false;
    protected function register()
    {
        $album = Field::type('select', [
            'label' => 'Album',
            'column' => 'Name',
            'options' => function () {
                $options = [];
                $model = Field::getModel('Album');
                $albums = $model->getAll();
                foreach ($albums as $album) {
                    $options[$album->getId()] = $album->name;
                }

                return $options;
            },
            'index' => true,
            'rules' => ['required'],
        ]);
        $photos = Field::type('photos', [
            'label' => 'Upload Photos',
            'column' => 'Photos',
            'rules' => ['required'],
        ]);
        $this->add('album_id', $album);
        $this->add('photos', $photos);
        $this->setFormAttributes([
            'class' => 'PhotoForm',
        ]);
    }
    public function store($data)
    {
        $result = false;
        $validator = Validator::make($data, $this->getRules());
        if ($validator->fails()) {
            $this->setErrors($validator->errors());
        } else {
            $photos = isset($data['photos']) ? $data['photos'] : [];
            foreach ($photos as $photo) {
                $photo['album_id'] = $data['album_id'];
                $repository = RepositoryFactory::create('Field\Field');
                $result = $repository->store($this->getName(), $photo);
            }
        }

        return $result;
    }
}
