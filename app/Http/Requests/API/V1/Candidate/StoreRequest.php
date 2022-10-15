<?php

namespace App\Http\Requests\API\V1\Candidate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|regex:/^[a-zA-Z\s]+$/',
            'last_name' => 'nullable|regex:/^[a-zA-Z\s]+$/',
            'birth_date' => 'required|date|date_format:Y-m-d|before:18 years ago',
            'email' => 'required|email:rfc,dns|unique:candidates,email',
            'phone_number' => 'required|unique:candidates,phone_number|numeric|digits_between:10,13',
            'education_id' => 'required|integer|exists:educations,id',
            'skill_ids' => [
                'required',
                'array',
                'size:5',
                Rule::prohibitedIf((count(array_unique($this->skill_ids)) < 5)),
            ],
            'skill_ids.*' => [
                'required',
                'integer',
                'exists:skills,id'
            ],
            'last_position_id' => 'required|integer|exists:positions,id',
            'applied_position_id' => 'required|integer|exists:positions,id',
            'experience.time' => 'required|numeric',
            'experience.time_type' => [
                'nullable',
                'alpha',
                Rule::in(['year', 'month'])
            ],
            // 'resume_file' => [
            //     'required',
            //     File::types('pdf')
            //         ->max(3 * 1024) // max file size 3 MB
            // ]
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.regex' => 'First Name only contains letters and whitespaces',
            'last_name.regex' => 'Last Name only contains letters and whitespaces',
            'skill_ids.prohibited' => 'The selected skill cannot be the same',
            'experience.time_type.in' => 'Experience.time type must be one of the following values: year or month',
        ];
    }
}
