<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'mobile' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'A Name is required',
            'mobile.required' => 'A Mobile is required',
        ];
    }

    public function attributes()
    {
        return [
            'mobile' => 'Mobile Number',
        ];
    }
}
