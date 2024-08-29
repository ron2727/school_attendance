<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => ['required', 'alpha'],
            'lastName' => ['required', 'alpha'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->input('id'))],
            'password' => ['sometimes', 'nullable', 'required', 'confirmed']
        ];
    } 
}
