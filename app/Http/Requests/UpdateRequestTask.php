<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:256',
            'description' => 'required',
            'status' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'title.required' => 'Название обезательное',
            'title.max' => 'Максимальная длина названия 256',
            'description.required' => 'Описание обезательное',
            'status.required' => 'Статус обезательное',
        ];
    }
}
