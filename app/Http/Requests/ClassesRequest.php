<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassesRequest extends FormRequest
{ 

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subject' => ['required', 'alpha_num'],
            'user_id' => ['required'],
            'grade_section' => ['required'],
            'time_from' => ['required'],
            'time_to' => ['required', 'after:time_from'],
            'academic_year' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Please select teacher',
            'time_to.after' => 'The time to should be after of time from'
        ];
    }
}
