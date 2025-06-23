<?php

namespace App\Http\Requests\Api;

use App\Traits\ApiResponseTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreCategoryRequest extends FormRequest
{
    use ApiResponseTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|array',
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
            'branches' => 'required|exists:branches,id',
            'is_primary' => 'sometimes|boolean',

        ];
    }
public function messages(): array
{
    return [
        'name.required' => __('validation.category.name_required'),
        'name.array' => __('validation.category.name_array'),

        'name.ar.required' => __('validation.category.name_ar_required'),
        'name.ar.string' => __('validation.string', ['attribute' => __('validation.attributes.name_ar')]),
        'name.ar.max' => __('validation.max.string', ['attribute' => __('validation.attributes.name_ar'), 'max' => 255]),

        'name.en.required' => __('validation.category.name_en_required'),
        'name.en.string' => __('validation.string', ['attribute' => __('validation.attributes.name_en')]),
        'name.en.max' => __('validation.max.string', ['attribute' => __('validation.attributes.name_en'), 'max' => 255]),

        'branches.required' => __('validation.category.branch_id_required'),
        'branches.exists' => __('validation.category.branch_id_exists'),
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
