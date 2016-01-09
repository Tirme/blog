<?php

namespace App\Http\Controllers;

use App\Fields\User;
use Field;
use Illuminate\Http\Request;

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
        $hash = $request->get('hash', '');
        $params = Field::decryptHash($hash);
        if ($params !== false) {
            $model_name = $params['model_name'];
            $model = Field::getModel($model_name);
            if ($model !== null) {
                $model->create($request->all());
                if ($model->hasError()) {
                    return redirect()
                        ->route('model_create_form', [
                            'model_name' => $model_name,
                        ])
                        ->with('errors', $model->getErrors()->getMessages())
                        ->withInput();
                } else {
                    return redirect()
                        ->route('model_list', [
                            'model_name' => $model->getName(),
                        ]);
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
        $hash = $request->get('hash', '');
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
                        ->route('model_edit_form', [
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
            }
        } else {
            return redirect('/');
        }
    }
}
