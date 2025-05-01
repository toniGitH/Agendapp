<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:25',
            'username' => [
                'required',
                'string',
                'max:9',
                Rule::unique('users', 'username')->ignore($this->route('user')->id)
            ],
            'is_admin' => 'nullable|boolean',
            'password' => 'nullable|string|min:5',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            'delete_image' => 'sometimes|in:on',
        ];
        // Only if user has contacts
        if ($this->userHasContacts()) {
            $rules['new_owner'] = 'nullable|exists:users,id'; // Validar el cambio de propietario de los contactos
        }
        
        return $rules;
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'The name is required.',
            'name.string' => 'Please provide a valid name.',
            'name.max' => 'Use less than 25 characters.',
            'username.required' => 'The username is required.',
            'username.string' => 'Please provide a valid username.',
            'username.unique' => 'This username is already taken.',
            'username.max' => 'Use less than than 9 characters.',
            'is_admin.required' => 'You must select the user role.',
            'is_admin.boolean' => 'The is_admin field must be true or false.',
            'password.string' => 'The password must be a valid string.',
            'password.min' => 'Use at least 5 characters.',
            'image.image' => 'File must be a valid image.',
            'image.mimes' => 'File must be of type: JPEG, PNG, JPG, GIF, SVG',
            'image.max' => 'Maximum size 2MB.',
            'delete_image.in' => 'If checked, can only have the value "on".',
        ];
    }

    protected function userHasContacts(): bool
    {
        return $this->user()->contacts()->exists();
    }
}
