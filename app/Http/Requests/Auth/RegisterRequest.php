<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'user_type' => 'required|string|in:student,teacher',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'phone' => 'required|regex:/(09)[0-9]{8}$/|unique:users',
            'school' => $this->input('user_type') === 'student' ? 'required|string|max:255' : 'missing',
            'bio' => $this->input('user_type') === 'teacher' ? 'required|string|max:255' : 'missing',
            'subject' => $this->input('user_type') === 'teacher' ? 'required|array|exists:subjects,id' : 'missing', // Subject is required if user_type is teacher
            'avatar' => 'nullable|image|max:5120', // 5MB max file size, only image files
            'password' => 'required|string|min:8|max:255',
            'device_token'=>'required|string'
        ];
    }
}
