<?php

namespace App\Modules\JobSeeker\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchJobRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|string|max:100',
            'location' => 'sometimes|string|max:100',
            'keywords' => 'sometimes|string|max:200',
            'page' => 'sometimes|integer|min:1',
            'per_page' => 'sometimes|integer|min:1|max:100',
        ];
    }

    public function messages()
    {
        return [
            'title.max' => 'The job title must not exceed 100 characters.',
            'location.max' => 'The location must not exceed 100 characters.',
            'keywords.max' => 'The keywords must not exceed 200 characters.',
            'page.integer' => 'The page must be a valid integer.',
            'page.min' => 'The page must be at least 1.',
            'per_page.integer' => 'The per_page value must be a valid integer.',
            'per_page.min' => 'The per_page value must be at least 1.',
            'per_page.max' => 'The per_page value must not exceed 100.',
        ];
    }
}
