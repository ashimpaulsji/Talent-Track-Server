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
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'country' => 'required|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'newsletter' => 'required|boolean',
            'terms' => 'required|boolean|accepted',
            'role' => 'required|in:employee,job_seeker,admin',
        ];
    }
}
