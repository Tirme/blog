<?php

namespace App\Fields;

use Field;
use Validator;

class Photo extends Model
{
    public static $_menu_available = false;
    protected function _register()
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
        $this->_add('album', $album);
        $this->_add('photos', $photos);
        $this->_setFormAttributes([
            'class' => 'PhotoForm',
        ]);
    }
    public function create($data)
    {
        $result = false;
        $validator = Validator::make($data, $this->getRules());
        if ($validator->fails()) {
            $this->_setErrors($validator->errors());
        } else {
            $photos = $data['photo'];
            foreach ($photos as $photo) {
                $photo['album'] = $data['album'];
                Field::storage($this->getName())
                    ->insert($photo);
            }
        }

        return $result;
    }
}
