<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:25',
            'registerUsername' => 'required|string|max:9|unique:users,username',
            'registerPassword' => 'required|min:5|confirmed',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name is required.',
            'name.max' => 'The name may not be greater than 25 characters.',
            'name.string' => 'Please provide a valid name.',
            'registerUsername.required' => 'The username is required.',
            'registerUsername.unique' => 'This username is already taken.',
            'registerUsername.max' => 'The username may not be greater than 9 characters.',
            'registerUsername.string' => 'Please provide a valid username.',
            'registerPassword.required' => 'The password field is required.',
            'registerPassword.min' => 'The password must be at least 5 characters long.',
            'registerPassword.confirmed' => 'The password confirmation does not match.',
            'profile_img.image' => 'File must be a valid image.',
            'profile_img.mimes' => 'File must be of type: JPEG, PNG, JPG, GIF',
            'profile_img.max' => 'Maximum size 2MB.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator, 'register') // 'register' error bag
                ->withInput() // Maintain the entered data
        );
    }
}
