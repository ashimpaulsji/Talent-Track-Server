<?php

namespace App\Modules\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:employee,job_seeker,admin',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
        ];

        switch ($this->input('role')) {
            case 'employee':
                $rules['position'] = 'nullable|string';
                $rules['department'] = 'nullable|string';
                break;
            case 'job_seeker':
                $rules['resume'] = 'nullable|string';
                $rules['skills'] = 'nullable|string';
                $rules['experience'] = 'nullable|string';
                break;
            case 'admin':
                $rules['admin_role'] = 'nullable|string';
                break;
        }

        return $rules;
    }
}
