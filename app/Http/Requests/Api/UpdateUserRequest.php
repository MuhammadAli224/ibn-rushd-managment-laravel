<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
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
        $userId = auth()->id();
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $userId,
            'phone' => 'sometimes|string|unique:users,phone,' . $userId,
            'password' => 'sometimes|string|min:6|confirmed',
            'is_active' => 'sometimes|boolean',
            'tax_number' => 'nullable|string|unique:users,tax_number,' . $userId,
            'comerical_number' => 'nullable|string|unique:users,comerical_number,' . $userId,
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => __('validation.name_string'),
            'email.email' => __('validation.email_valid'),
            'email.unique' => __('validation.email_unique'),
            'phone.unique' => __('validation.phone_unique'),
            'password.min' => __('validation.password_min'),
            'password.confirmed' => __('validation.password_confirmed'),
            'tax_number.unique' => __('validation.tax_number_unique'),
            'comerical_number.unique' => __('validation.comerical_number_unique'),
        ];
    }
}
