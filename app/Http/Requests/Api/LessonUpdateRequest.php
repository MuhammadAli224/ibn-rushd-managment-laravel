<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LessonUpdateRequest extends FormRequest
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
            'id'              => ['required', 'exists:lessons,id'],
            'lesson_date'      => ['sometimes', 'date'],
            'lesson_start_time' => ['sometimes', 'date_format:H:i:s'],
            'lesson_end_time'   => ['sometimes', 'date_format:H:i:s', 'after:lessonStartTime'],
            'lesson_location'  => ['sometimes', 'nullable', 'string', 'max:255'],
            'lesson_notes'     => ['sometimes', 'nullable', 'string'],
            'lesson_duration'  => ['sometimes', 'nullable', 'integer', 'min:1'],
            'check_in_time'     => ['sometimes', 'nullable', 'date_format:H:i:s'],
            'check_out_time'    => ['sometimes', 'nullable', 'date_format:H:i:s', 'after:checkInTime'],
            'lesson_price'     => ['sometimes', 'numeric', 'min:0'],
            'status'          => ['sometimes', 'in:SCHEDULED,IN_PROGRESS,COMPLETED,CANCELLED'],
            'uber_charge'      => ['sometimes', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [

            'lessonDate.date'    => __('validation.lesson_date_valid'),

            'lessonStartTime.date_format' => __('validation.lesson_start_format'),

            'lessonEndTime.date_format'   => __('validation.lesson_end_format'),
            'lessonEndTime.after'         => __('validation.lesson_end_after'),

            'lessonLocation.string' => __('validation.lesson_location_string'),
            'lessonLocation.max'    => __('validation.lesson_location_max'),

            'lessonNotes.string'   => __('validation.lesson_notes_string'),

            'lessonDuration.integer' => __('validation.lesson_duration_integer'),
            'lessonDuration.min'     => __('validation.lesson_duration_min'),

            'checkInTime.date_format'  => __('validation.checkin_format'),
            'checkOutTime.date_format' => __('validation.checkout_format'),
            'checkOutTime.after'       => __('validation.checkout_after'),

            'lessonPrice.numeric' => __('validation.lesson_price_numeric'),
            'lessonPrice.min'     => __('validation.lesson_price_min'),

            'status.in'           => __('validation.status_invalid'),
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
