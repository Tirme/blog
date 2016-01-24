<?php

namespace App\Http\Requests\Podm;

use App\Http\Requests\Request;

class UploadPhotoRequest extends Request
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'photo' => [
                'required',
                // 'mimes:jpeg',
                'max:'.(1024 * 10),
            ],
        ];
    }
    public function messages()
    {
        return [
            'photo.max' => 'file size can not greater than 3 MB.',
        ];
    }
}
