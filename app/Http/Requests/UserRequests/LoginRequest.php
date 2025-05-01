<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'loginUsername' => 'required|string|max:255',
            'loginPassword' => 'required|min:5',
        ];
    }

    public function messages(): array
    {
        return [
            'loginUsername.required' => 'The username is required.',
            'loginUsername.string' => 'Please provide a valid username.',
            'loginPassword.required' => 'The password field is required.',
            'loginPassword.min' => 'The password must be at least 5 characters long.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator, 'login') // 'login' error bag
                ->withInput() // Maintain the entered data
        );
    }
}
