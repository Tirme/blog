<?php

namespace App\Podm;

use Podm;
use Validator;
use RepositoryFactory;

class Photo extends Model
{
    public static $menu_available = false;
    protected function register()
    {
        $album = Podm::type('select', [
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
        $photos = Podm::type('photos', [
            'label' => 'Upload Photos',
            'column' => 'Photos',
            'rules' => ['required'],
        ]);
        $this->add('album_id', $album)
            ->add('photos', $photos)
            ->setFormAttributes([
                'class' => 'PhotoForm',
            ]
        );
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
                $repository = RepositoryFactory::create('Podm\Podm');
                $result = $repository->store($this->getName(), $photo);
            }
        }

        return $result;
    }
}
