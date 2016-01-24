<?php

namespace App\Podm\Repositories\Gallery;

use App\Podm\Repositories\Repository;
use App\Podm\Storage\FieldModel;
use App\Podm\Eloquence\Photo as PhotoModel;

class PhotoRepository extends Repository
{
    public function get($id)
    {
        $photo = PhotoModel
            ::where('_id', $id)
            ->first();

        return $photo;
    }
    public function getList($album_id, $perpage = 10)
    {
        $pagination = PhotoModel
            ::where('album_id', $album_id)
            ->paginate($perpage);
        return $pagination;
    }
    public function getAll($album_id) {
        $collection = PhotoModel
            ::where('album_id', $album_id)
            ->get();
        return $collection;
    }
    public function getAlbumCover($album_id)
    {
        $model = new PodmModel();
        $model->setCollection('Photo');
        $row = $model
            ->where('album_id', $album_id)
            ->take(1);

        return $row;
    }
    public function queryForImport($date, $perpage)
    {
        $collection = PhotoModel
            ::where('date', $date)
            ->whereNull('album_id')
            ->paginate($perpage);

        return $collection;
    }
    public function update($id, $data) {
        $photo = PhotoModel
            ::where('_id', $id)
            ->first();
        if ($photo) {
            $photo->fill($data);
            $photo->save();
        }
    }
    public function upsert($data, $date, $file_name)
    {
        $photo = PhotoModel
            ::where('date', $date)
            ->where('file_name', $file_name)
            ->first();
        if ($photo) {
            $photo->fill($data);
            $result = $photo->save();
        } else {
            $new_photo = new PhotoModel();
            $new_photo->fill($data);
            $result = $new_photo->save();
        }

        return $result;
    }
}
