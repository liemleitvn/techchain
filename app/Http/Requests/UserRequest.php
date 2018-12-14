<?php

namespace App\Http\Requests;
use Lang;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'email'   => 'required|unique:users,email|email',
        ];
    }
    public function messages()
    {
        return [
           'email.required'        => Lang::get('messages.username.required'),
           'email.unique'          => Lang::get('messages.username.unique'),
           'email.email'           => Lang::get('messages.username.error'),
        ];
    }
}
