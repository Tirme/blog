<?php

namespace App\Fields;

use Field;
use Validator;

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
            'column' => 'Photos'
        ]);
        $this->add('album_id', $album);
        $this->add('photos', $photos);
        $this->setFormAttributes([
            'class' => 'PhotoForm',
        ]);
    }
    public function create($data)
    {
        $result = false;
        $validator = Validator::make($data, $this->getRules());
        if ($validator->fails()) {
            $this->setErrors($validator->errors());
        } else {
            $photos = $data['photo'];
            foreach ($photos as $photo) {
                $photo['album_id'] = $data['album_id'];
                Field::storage($this->getName())
                    ->insert($photo);
            }
        }

        return $result;
    }
}
