<?php

namespace App\Http\Controllers;

use App\Fields\User;
use App\Http\Requests\Fields\UploadPhotoRequest;
use Field;
use Illuminate\Http\Request;
use RepositoryFactory;
use Eventviva\ImageResize;

class FieldController extends Controller
{
    public function test()
    {
        //            $user = new User();
//            $user->name = 'Peter';
//            $user->email = 'tirme0812@gmail.com';
////            tirme($user);
//            tirme(Field::models());
            $projections = array('id', 'name');
//            $collection = \DB::connection('mongodb')->collection('Users')->paginate(10);
            tirme($collection);
    }
    public function listPage($model_name, $per_page = 10)
    {
        $model = Field::getModel($model_name);
        if ($model !== null) {
            return view('admin', [
                'menu' => Field::getMenu(),
                'content' => $model->getList($per_page),
            ]);
        } else {
            return redirect('/');
        }
    }
    public function create($model_name)
    {
        $model = Field::getModel($model_name);
        if ($model) {
            $user_values = old();

            return view('admin', [
                'menu' => Field::getMenu(),
                'content' => $model->getCreateForm($user_values),
                'errors' => session('errors', []),
            ]);
        } else {
            return redirect('/');
        }
    }
    public function store(Request $request)
    {
        $hash = $request->input('_hash', '');
        $success_redirect = $request->input('redirect.success', null);
        $error_redirect = $request->input('redirect.error', null);
        $params = Field::decryptHash($hash);
        if ($params !== false) {
            $model_name = $params['model_name'];
            $model = Field::getModel($model_name);
            if ($model !== null) {
                $model->create($request->all());
                if ($model->hasError()) {
                    if ($error_redirect !== null) {
                        return redirect($error_redirect);
                    } else {
                        return redirect()
                            ->route('model_create', [
                                'model_name' => $model_name,
                            ])
                            ->with('errors', $model->getErrors()->getMessages())
                            ->withInput();
                    }
                } else {
                    if ($success_redirect !== null) {
                        return redirect($success_redirect);
                    } else {
                        return redirect()
                            ->route('model_list', [
                                'model_name' => $model->getName(),
                            ]);
                    }
                }
            } else {
                throw new FieldFormException('model not exists.');
            }
        } else {
            return redirect('/');
        }
    }
    public function edit($model_name, $id)
    {
        $model_name = snake_case($model_name);
        $model = Field::getModelById($model_name, $id);
        if ($model !== null) {
            $user_values = old();

            return view('admin', [
                'content' => $model->getEditForm($user_values),
                'menu' => Field::getMenu(),
                'errors' => session('errors', []),
            ]);
        } else {
            return redirect('/');
        }
    }
    public function update(Request $request)
    {
        $hash = $request->get('_hash', '');
        $params = Field::decryptHash($hash);
        if ($params !== false) {
            $model_name = $params['model_name'];
            $id = $params['_id'];
            $model = Field::getModelById($model_name, $id);
            if ($model !== null) {

                $user_values = $request->all();
                $model->update($user_values);
                if ($model->hasError()) {
                    return redirect()
                        ->route('model_edit', [
                            'model_name' => $model_name,
                            'id' => $id,
                        ])
                        ->with('errors', $model->getErrors()->getMessages())
                        ->withInput();
                } else {
                    return redirect()
                        ->route('model_list', [
                            'model_name' => $model_name,
                        ]);
                }
            } else {
                return redirect()->route('model_list', [
                    'model_name' => $model_name,
                ]);
            }
        } else {
            return redirect('/');
        }
    }
    public function uploadPhoto(UploadPhotoRequest $request)
    {
        $result = [
            'photos' => [],
        ];
        $hash = $request->get('_hash', '');
        $params = Field::decryptHash($hash);
        if ($params !== false) {
            $model_name = $params['model_name'];
            $photos = $request->file('photo');
            $temp_path = storage_path('fields/upload/photo/temp');
            // https://github.com/Intervention/image
            foreach ($photos as $photo) {
                if ($photo->isValid()) {
                    $photo_id = uniqid();
                    $photo_path = $photo->getPath().'/'.$photo->getFilename();
                    $photo_data = file_get_contents($photo_path);
                    $base64 = base64_encode($photo_data);
                    $mine_type = mime_content_type($photo_path);
                    $image = new ImageResize($photo_path);
                    $image->resizeToBestFit(300, 225);
                    // $image->resize(300, 225);
                    // $image->scale(100);
                    $base64 = base64_encode($image->getImageAsString());
                    $photo->move($temp_path, $photo_id);
                    $result['photos'][] = [
                        'id' => $photo_id,
                        'mine_type' => $mine_type,
                        'base64' => $base64,
                        // 'p' => $p
                    ];
                }
            }

            return response()->json($result);
        } else {
            // response hash error
        }
    }
}
