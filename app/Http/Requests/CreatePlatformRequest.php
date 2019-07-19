<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreatePlatformRequest extends FormRequest
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
        $statusTypes = implode(',', array_keys(trans('platform.status_types')));

        return [
            'name'    => 'required|max:255',
            'db_name' => 'required|max:50',
            'status'  => "required|in:{$statusTypes}",
            'note'    => 'max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required'    => trans('message.required', ['item' => trans('platform.name')]),
            'name.max'         => trans('message.max_string', ['item' => trans('platform.name'), 'value' => 255]),
            'db_name.required' => trans('message.required', ['item' => trans('platform.db_name')]),
            'db_name.max'      => trans('message.max_string', ['item' => trans('platform.db_name'), 'value' => 50]),
            'status.required'  => trans('message.required', ['item' => trans('platform.status')]),
            'status.in'        => trans('message.in', ['item' => trans('platform.status')]),
            'note.max'         => trans('auth.error_format_password', ['item' => trans('platform.note'), 'value' => 255]),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->redirector
            ->to($this->getRedirectUrl())
            ->withErrors($validator->errors(), $this->errorBag)
            ->with(['message_fail' => $validator->errors()->first()])
            ->throwResponse();
    }
}
