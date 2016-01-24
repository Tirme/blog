<?php

namespace App\Http\Requests\Gallery;

use App\Http\Requests\Request;

class PhotoImportRequest extends Request
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'album_id' => [
                'required',
                'podm_ref:album'
            ],
        ];
    }
    public function messages()
    {
        return [
            'album_id.podm_ref' => '請選擇相簿',
        ];
    }
}
