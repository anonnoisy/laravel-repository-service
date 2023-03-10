<?php

namespace App\Http\Requests\API\V1\Candidate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UploadRequest extends FormRequest
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
            'candidate_email' => 'required',
            'resume_file' => 'required|mimes:pdf|max:6144' // max file size 4 MB
        ];
    }
}
