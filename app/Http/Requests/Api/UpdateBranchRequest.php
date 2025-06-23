<?php

namespace App\Http\Requests\Api;

use App\Models\Branch;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBranchRequest extends FormRequest
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
        $branchId = $this->route('id');
        $branch = Branch::find($branchId);

        return [
            'name' => 'required|string|max:255',
            'tax_number' => [
                'required',
                'string',
                $branch && $branch->tax_number !== $this->tax_number ? 'unique:branches,tax_number,' . $branchId : '',
            ],
            'comerical_number' => [
                'required',
                'string',
                $branch && $branch->comerical_number !== $this->comerical_number ? 'unique:branches,comerical_number,' . $branchId : '',
            ],
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.name_required'),
            'name.string' => __('validation.name_string'),

            'tax_number.required' => __('validation.tax_number_required'),
            'tax_number.string' => __('validation.tax_number_string'),
            'tax_number.unique' => __('validation.tax_number_unique'),

            'comerical_number.required' => __('validation.comerical_number_required'),
            'comerical_number.string' => __('validation.comerical_number_string'),
            'comerical_number.unique' => __('validation.comerical_number_unique'),

            'image.image' => __('validation.image_image'),
            'image.mimes' => __('validation.image_mimes'),
            'image.max' => __('validation.image_max'),
        ];
    }
}
