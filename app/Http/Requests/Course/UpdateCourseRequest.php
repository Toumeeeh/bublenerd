<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'name' => 'string|max:255', // max length based on typical DB VARCHAR
            'price' => 'numeric|min:0|max:999999.99', // Adjust range as needed
            'old_price' => 'numeric|min:0|max:999999.99', // Adjust range as needed
            'description' => 'string',
            'photo' => 'nullable|image|max:2048', // 2MB max file size, only image files
            'subject_id'=>'int'

        ];
    }
}
