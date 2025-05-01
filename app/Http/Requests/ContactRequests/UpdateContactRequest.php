<?php

namespace App\Http\Requests\ContactRequests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name_1' => 'required|string|max:255',
            'last_name_2' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'email' => [
                'required',
                'email',
                'regex:/^[\w\.-]+@[a-zA-Z0-9\-]+\.[a-zA-Z]{2,}$/i',
                'max:255',
                // Conditional validation: if it's an update, ignore the current email value.
                'unique:contacts,email,' . $this->route('contact')->id
            ],
            'mobile' => [
                'required',
                'digits:9',
                // Conditional validation: if it's an update, ignore the current mobile value.
                'unique:contacts,mobile,' . $this->route('contact')->id
            ],
            'landline' => 'nullable|digits:9',
            'city' => 'required|string|max:255',
            'province' => 'required_if:country,Spain|string|max:255|nullable', // Default rule
            'country' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id'
        ];
    }

    /**
     * Custom error messages for validation failures.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name_1.required' => 'Last name 1 is required.',
            'image.image' => 'The file must be a valid image.',
            'image.mimes' => 'File must be of type: JPEG, PNG, JPG, GIF, SVG',
            'image.max' => 'Maximum size 2MB.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.regex' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'mobile.required' => 'Mobile phone number is required.',
            'mobile.digits' => 'Mobile phone number must be exactly 9 digits.',
            'mobile.unique' => 'This mobile phone number is already registered.',
            'landline.digits' => 'Landline phone number must be exactly 9 digits.',
            'city.required' => 'City is required.',
            'province.required_if' => 'Province is required if the city is Spain.',
            'country.required' => 'Country is required.',
            'notes.max' => 'Notes must not exceed 255 characters.',
            'user_id.required' => 'You must assign the contact to an existing user.'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $country = trim(mb_strtolower($this->input('country')));
            $province = $this->input('province');
    
            $acceptedSpainNames = ['spain', 'españa'];
    
            if (in_array($country, $acceptedSpainNames)) {
                if (empty($province)) {
                    $validator->errors()->add('province', 'Province is required when country is Spain.');
                }
            } else {
                if (!empty($province)) {
                    $validator->errors()->add('province', 'Province must be empty when country is not Spain.');
                }
            }
        });
    }
    
}
