<?php

namespace App\Http\Requests\Api;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClientRegisterRequest extends FormRequest
{
    use ApiResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:8',
            'tax_number' => 'required|string|unique:users,tax_number',
            'comerical_number' => 'required|string|unique:users,comerical_number',
            'fcm_token' => 'nullable|string',
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
            'tax_number.required' => __('validation.tax_number_required'),
            'tax_number.unique' => __('validation.tax_number_unique'),
            'comerical_number.required' => __('validation.comerical_number_required'),
            'comerical_number.unique' => __('validation.comerical_number_unique'),
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
