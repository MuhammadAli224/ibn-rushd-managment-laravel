<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateProductRequest extends FormRequest
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
        return [
            'name' => ['required', 'string'],
            'product_no' => ['required', 'integer', 'unique:products,product_no,' . $this->product],
            'price' => ['required', 'numeric'],
            'cost' => ['required', 'numeric'],
            'unit' => ['required', 'string'],
            'image' => ['nullable', 'image'],
            'category_id' => ['required', 'exists:categories,id'],
            'payment_type' => ['required', 'in:by_quantity,by_price'],
            'is_active' => ['boolean'],

            'branches' => ['required', 'array'],
            'branches.*.id' => ['required', 'exists:branches,id'],
            'branches.*.quantity' => ['required', 'integer'],
            'branches.*.price' => ['required', 'numeric'],
            'branches.*.is_active' => ['boolean'],
            'branches.*.is_most_popular' => ['boolean'],
            'branches.*.status' => ['in:active,inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.product.name_required'),
            'name.string' => __('validation.product.name_string'),
            'name.max' => __('validation.product.name_max'),

            'price.required' => __('validation.product.price_required'),
            'price.numeric' => __('validation.product.price_numeric'),

            'cost.required' => __('validation.product.cost_required'),
            'cost.numeric' => __('validation.product.cost_numeric'),

            'unit.required' => __('validation.product.unit_required'),
            'unit.string' => __('validation.product.unit_string'),
            'unit.max' => __('validation.product.unit_max'),

            'image.image' => __('validation.product.image_image'),
            'image.mimes' => __('validation.product.image_mimes'),
            'image.max' => __('validation.product.image_max'),

            'product_no.required' => __('validation.product.product_no_required'),
            'product_no.integer' => __('validation.product.product_no_integer'),
            'product_no.unique' => __('validation.product.product_no_unique'),

            'category_id.required' => __('validation.product.category_id_required'),
            'category_id.exists' => __('validation.product.category_id_exists'),

            'payment_type.required' => __('validation.product.payment_type_required'),
            'payment_type.in' => __('validation.product.payment_type_in'),

            'branches.required' => __('validation.product.branches_required'),
            'branches.array' => __('validation.product.branches_array'),

            'branches.*.id.required' => __('validation.product.branch_id_required'),
            'branches.*.id.exists' => __('validation.product.branch_id_exists'),

            'branches.*.quantity.required' => __('validation.product.quantity_required'),
            'branches.*.quantity.integer' => __('validation.product.quantity_integer'),

            'branches.*.price.required' => __('validation.product.price_required'),
            'branches.*.price.numeric' => __('validation.product.price_numeric'),

            'branches.*.is_active.boolean' => __('validation.product.is_active_boolean'),
            'branches.*.is_most_popular.boolean' => __('validation.product.is_most_popular_boolean'),

            'branches.*.status.in' => __('validation.product.status_in'),
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
