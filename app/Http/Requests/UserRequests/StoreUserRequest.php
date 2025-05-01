<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:25',
            'username' => 'required|string|unique:users,username|max:9',
            'is_admin' => 'required|boolean',
            'password' => 'required|string|min:5',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name is required.',
            'name.string' => 'Please provide a valid name.',
            'name.max' => 'The name may not be greater than 25 characters.',
            'username.required' => 'The username is required.',
            'username.string' => 'Please provide a valid username.',
            'username.unique' => 'This username is already taken.',
            'username.max' => 'The username may not be greater than 9 characters.',
            'is_admin' => 'You must select the user role',
            'is_admin.boolean' => 'The is_admin field must be true or false.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a valid string.',
            'password.min' => 'The password must be at least 5 characters long.',
            'image.image' => 'File must be a valid image.',
            'image.mimes' => 'File must be of type: JPEG, PNG, JPG, GIF, SVG',
            'image.max' => 'Maximum size 2MB.',
        ];
    }
}
