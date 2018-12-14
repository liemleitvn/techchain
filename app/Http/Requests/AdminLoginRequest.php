<?php

namespace App\Http\Requests;
use Lang;
use Illuminate\Foundation\Http\FormRequest;

class AdminLoginRequest extends FormRequest
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
            'username'     => 'required|email',
            'password'  => 'required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'username.required'    => Lang::get('messages.username.required'),
            'username.email'       => Lang::get('messages.username.email'),
            'password.required'    => Lang::get('messages.password.required'),
            'password.min'         => Lang::get('messages.password.min')
        ];
    }
}
