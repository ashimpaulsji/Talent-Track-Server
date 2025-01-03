<?php

namespace App\Modules\Job\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'requirements' => 'sometimes|required|array',
            'responsibilities' => 'sometimes|required|array',
            'location' => 'sometimes|required|string|max:255',
            'salary_range' => 'sometimes|required|string|max:100',
            'employment_type' => 'sometimes|required|string|max:50',
            'experience_level' => 'sometimes|required|string|max:50',
            'category' => 'sometimes|required|string|max:100',
            'tags' => 'sometimes|required|array',
        ];
    }
}
