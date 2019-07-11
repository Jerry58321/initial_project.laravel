<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'account'  => 'required|between:6,30|alpha_dash',
            'password' => 'required|between:6,12|alpha_num',
            'captcha'  => 'required|captcha'
        ];
    }

    public function messages()
    {
        return [
            'account.required'  => trans('auth.required_account'),
            'password.required' => trans('auth.required_password'),
            'captcha.required'  => trans('auth.required_captcha'),
            'account.*'         => trans('auth.error_format_account'),
            'password.*'        => trans('auth.error_format_password'),
        ];
    }
}
