<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lang;
class AccountAdminRequest extends FormRequest
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
            'email'     => 'required|email|unique:admins,email',
            'password'  => 'required|min:6'
        ];
    }
    public function messages()
    {
        return [
            'email.required'  => Lang::get('messages.username.required'),
            'email.email'     => Lang::get('messages.username.error'),
            'email.unique'    => Lang::get('messages.username.unique'),
            'password.required' => Lang::get('messages.password.required'),
            'password.min'      => Lang::get('messages.password.min'),
        ];
    }
}
