<?php

namespace App\Modules\Profile\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'photo' => 'nullable|string',
            'address' => 'required|string',
            'phone' => 'required|string',
        ];

        switch (auth()->user()->role) {
            case 'employee':
                $rules['position'] = 'required|string';
                $rules['department'] = 'required|string';
                break;
            case 'job_seeker':
                $rules['resume'] = 'required|string';
                $rules['skills'] = 'required|string';
                $rules['experience'] = 'required|string';
                break;
            case 'admin':
                $rules['admin_role'] = 'required|string';
                break;
        }

        return $rules;
    }
}