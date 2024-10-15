<?php

namespace App\Modules\Employer\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobPostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'requirements' => 'required|string',
            'responsibilities' => 'required|string',
            'location' => 'required|string|max:255',
            'salary_range' => 'required|string|max:100',
            'employment_type' => 'required|string|max:50',
            'experience_level' => 'required|string|max:50',
        ];
    }
}
