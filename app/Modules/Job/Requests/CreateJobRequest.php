<?php

namespace App\Modules\Job\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateJobRequest extends FormRequest
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
            'requirements' => 'required|array',
            'responsibilities' => 'required|array',
            'location' => 'required|string|max:255',
            'salary_range' => 'required|string|max:100',
            'employment_type' => 'required|string|max:50',
            'experience_level' => 'required|string|max:50',
            'category' => 'required|string|max:100',
            'tags' => 'required|array',
        ];
    }
}
