<?php

namespace App\Modules\JobSeeker\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'resume' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:10240',
            'skills' => 'required|array',
            'skills.*' => 'string|max:50',
            'experience' => 'required|string|max:5000',
        ];
    }

    public function messages()
    {
        return [
            'resume.required' => 'A resume file is required.',
            'resume.file' => 'The resume must be a file.',
            'resume.mimes' => 'The resume must be a PDF, DOC, DOCX, PNG, JPG, or JPEG file.',
            'resume.max' => 'The resume must not be larger than 10MB.',
            'skills.required' => 'At least one skill is required.',
            'skills.array' => 'Skills must be provided as an array.',
            'skills.*.max' => 'Each skill must not exceed 50 characters.',
            'experience.required' => 'Experience information is required.',
            'experience.max' => 'The experience must not exceed 5000 characters.',
        ];
    }
}
