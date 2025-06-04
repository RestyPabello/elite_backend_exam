<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       return [
            'name'     => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|min:8| max:30|regex:/^[a-zA-Z0-9._-]+$/',
            'email'    => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',   
                'min:8',   
                'max:24',   
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,24}$/',
            ],
            'confirm_password' => 'required|string|min:8|same:password'
        ];
    }
}
