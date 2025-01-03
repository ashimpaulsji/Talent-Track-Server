<?php

namespace App\Modules\JobSeeker\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'resume' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:10240',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:50',
            'experience' => 'nullable|string|max:5000',
        ];
    }

    public function messages()
    {
        return [
            'resume.file' => 'The resume must be a file.',
            'resume.mimes' => 'The resume must be a PDF, DOC, DOCX, PNG, JPG, or JPEG file.',
            'resume.max' => 'The resume must not be larger than 10MB.',
            'skills.array' => 'Skills must be provided as an array.',
            'skills.*.max' => 'Each skill must not exceed 50 characters.',
            'experience.max' => 'The experience must not exceed 5000 characters.',
        ];
    }
}
