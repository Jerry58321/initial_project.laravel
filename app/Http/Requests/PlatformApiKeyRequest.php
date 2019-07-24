<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class PlatformApiKeyRequest extends FormRequest
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
            'status'     => "required|in:enable,disable",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $this->redirector
            ->to($this->getRedirectUrl())
            ->withErrors($validator->errors(), $this->errorBag)
            ->with(['message_fail' => $validator->errors()->first()])
            ->withInput()
            ->throwResponse();
    }
}
