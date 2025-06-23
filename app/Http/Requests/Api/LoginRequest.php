<?php

namespace App\Http\Requests\Api;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
{
    use ApiResponseTrait;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'login'    => 'required|string',
            'password' => 'required|string|min:6',
            'fcm_token' => 'nullable|string',
        ];
    }




    public function messages(): array
    {
        return [
            'login.required'  => __('validation.login_required'),
            'password.required' => __('validation.password_required'),
            'password.min' => __('validation.password_min'),

        ];
    }




    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->error(
                message: __('validation.failed'),
                statusCode: 422,
                error: $validator->errors()->first(),
            )

        );
    }
}
