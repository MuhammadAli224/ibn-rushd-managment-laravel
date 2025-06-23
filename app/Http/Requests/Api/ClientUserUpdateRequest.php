<?php

namespace App\Http\Requests\Api;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ClientUserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return \true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array

    {
        $userId = $this->route('id');
        return [
            'name'     => ['required', 'string', 'min:4', 'max:50'],
            'email'    => ['required', 'email', 'max:100', "unique:users,email,{$userId}"],
            'phone'    => ['required', 'string', 'min:8', 'max:20', "unique:users,phone,{$userId}"],
            'password' => ['nullable', 'string', 'min:8'],
            'branches' => ['required', 'array', 'min:1'],
            'branches.*' => ['integer', 'exists:branches,id'],
        ];
    }
     public function messages(): array
    {
        return [
            'name.required' => __('validation.name_required'),
            'name.string' => __('validation.name_string'),
            'email.required' => __('validation.email_required'),
            'email.email' => __('validation.email_valid'),
            'email.unique' => __('validation.email_unique'),
            'phone.required' => __('validation.phone_required'),
            'phone.unique' => __('validation.phone_unique'),
            'password.required' => __('validation.password_required'),
            'password.min' => __('validation.password_min'),
            'password.confirmed' => __('validation.password_confirmed'),
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
