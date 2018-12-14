<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;
class ImportFileRequest extends FormRequest
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
            'file' => 'required|max:5120'
        ];
    }
    public function messages()
    {
        return [
            'file.required' => Lang::get('messages.error.file'),
            'file.max'      => Lang::get('messages.error.file.large'),
        ];
    }
}
