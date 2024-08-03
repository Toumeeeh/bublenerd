<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
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
            'question'=>'string',
            'answer1'=>'string',
            'answer2'=>'string',
            'answer3'=>'string|nullable',
            'answer4'=>'string|nullable',
            'correct_answer'=>'string',
            'course_id'=>'int'
        ];
    }
}
