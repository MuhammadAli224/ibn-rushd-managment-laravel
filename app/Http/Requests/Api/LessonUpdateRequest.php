<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LessonUpdateRequest extends FormRequest
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
            'subject'        => ['sometimes', 'string', 'min:3', 'max:100'],
            'lessonDate'     => ['sometimes', 'date'],
            'lessonStartTime'=> ['sometimes', 'date_format:H:i'],
            'lessonEndTime'  => ['sometimes', 'date_format:H:i', 'after:lessonStartTime'],
            'lessonLocation' => ['sometimes', 'nullable', 'string', 'max:255'],
            'lessonNotes'    => ['sometimes', 'nullable', 'string'],
            'lessonDuration' => ['sometimes', 'integer', 'min:1'],
            'checkInTime'    => ['sometimes', 'date_format:H:i'],
            'checkOutTime'   => ['sometimes', 'date_format:H:i', 'after:checkInTime'],
            'lessonPrice'    => ['sometimes', 'numeric', 'min:0'],
        ];
    }
    public function attributes(): array
    {
                return [
            'subject.string' => __('validation.subject_string'),
            'subject.min'    => __('validation.subject_min'),
            'subject.max'    => __('validation.subject_max'),

            'lessonDate.date' => __('validation.lesson_date_valid'),

            'lessonStartTime.date_format' => __('validation.lesson_start_format'),

            'lessonEndTime.date_format' => __('validation.lesson_end_format'),
            'lessonEndTime.after'       => __('validation.lesson_end_after'),

            'lessonLocation.string' => __('validation.lesson_location_string'),
            'lessonLocation.max'    => __('validation.lesson_location_max'),

            'lessonNotes.string' => __('validation.lesson_notes_string'),

            'lessonDuration.integer' => __('validation.lesson_duration_integer'),
            'lessonDuration.min'     => __('validation.lesson_duration_min'),

            'checkInTime.date_format'  => __('validation.checkin_format'),
            'checkOutTime.date_format' => __('validation.checkout_format'),
            'checkOutTime.after'       => __('validation.checkout_after'),

            'lessonPrice.numeric' => __('validation.lesson_price_numeric'),
            'lessonPrice.min'     => __('validation.lesson_price_min'),
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
