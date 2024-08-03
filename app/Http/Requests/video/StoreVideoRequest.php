<?php

namespace App\Http\Requests\video;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
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
            'video' => 'required|file|max:10000000',
            'description' => 'required|string|max:255',
            'subject_id'=>'required|int'
        ];
    }
}
