<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'name' => 'required|string|max:255', // max length based on typical DB VARCHAR
            'price' => 'required|numeric|min:0|max:999999.99', // Adjust range as needed
            'old_price' => 'required|numeric|min:0|max:999999.99', // Adjust range as needed
            'description' => 'required|string',
            'photo' => 'nullable|image|max:2048', // 2MB max file size, only image files
          //  'user_id'=>'required',
            'subject_id'=>'required'
        ];
    }
}
