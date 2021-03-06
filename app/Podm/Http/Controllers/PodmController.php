<?php

namespace App\Podm\Http\Controllers;

use Podm;
use App\Http\Controllers\Controller;
use App\Http\Requests\Podm\UploadPhotoRequest;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class PodmController extends Controller
{
    public function test()
    {
        return view('PodmView::test', [
            'content' => 'ok'
        ]);
    }
    public function listPage(Request $request, $model_name, $per_page = 10)
    {
        $model = Podm::getModel($model_name);
        if ($model !== null) {
            return view('PodmView::list', [
                'model_name' => $model_name,
                'content' => $model->getListHtml($per_page),
            ]);
        } else {
            return redirect('/');
        }
    }

    public function createPage($model_name)
    {
        $model = Podm::getModel($model_name);
        if ($model) {
            $user_values = old();

            return view('PodmView::create_form', [
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
        $params = Podm::decryptHash($hash);
        if ($params !== false) {
            $model_name = $params['model_name'];
            $model = Podm::getModel($model_name);
            if ($model !== null) {
                $model->store($request->all());
                if ($model->hasError()) {
                    if ($error_redirect !== null) {
                        return redirect($error_redirect)
                                        ->with('errors', $model->getErrors()->getMessages())
                                        ->withInput();
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
                throw new PodmFormException('model not exists.');
            }
        } else {
            return redirect('/');
        }
    }

    public function editPage($model_name, $id)
    {
        $model_name = snake_case($model_name);
        $model = Podm::getModelById($model_name, $id);
        if ($model !== null) {
            $user_values = old();

            return view('PodmView::edit_form', [
                'content' => $model->getEditForm($user_values),
                'errors' => session('errors', []),
            ]);
        } else {
            return redirect('/');
        }
    }

    public function update(Request $request)
    {
        $hash = $request->get('_hash', '');
        $params = Podm::decryptHash($hash);
        if ($params !== false) {
            $model_name = $params['model_name'];
            $id = $params['_id'];
            $model = Podm::getModelById($model_name, $id);
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
        $params = Podm::decryptHash($hash);
        if ($params !== false) {
            $model_name = $params['model_name'];
            $photos = $request->file('photo');
            $temp_path = storage_path('Podms/upload/photo/temp');
            foreach ($photos as $photo) {
                if ($photo->isValid()) {
                    $photo_id = uniqid();
                    $photo_file = $photo->getPath().'/'.$photo->getFilename();
                    $mine_type = mime_content_type($photo_file);
                    $image = Image
                            ::make($photo_file);
                    $image->resize(300, 200, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $base64 = base64_encode($image->encode($mine_type));
                    $photo->move($temp_path, $photo_id);
                    $result['photos'][] = [
                        'id' => $photo_id,
                        'mine_type' => $mine_type,
                        'base64' => $base64,
                        'file_name' => $photo->getClientOriginalName(),
                    ];
                }
            }

            return response()->json($result);
        } else {
            // response hash error
        }
    }
}
