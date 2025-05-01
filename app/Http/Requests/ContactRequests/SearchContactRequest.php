<?php

namespace App\Http\Requests\ContactRequests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class SearchContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'nullable|in:all,' . $this->getUserIdsString(),
            'search' => 'nullable|string|max:255',
            'sort' => 'nullable|in:first_name,last_name_1,last_name_2,email,mobile',
            'direction' => 'nullable|in:asc,desc'
        ];
    }

    public function messages()
    {
        return [
            'search.string' => 'The search term must be a valid string.',
            'search.max' => 'The search term must not exceed 255 characters.',
            'user_id.in' => 'Please select a valid user.',
            'sort.in' => 'Invalid sorting option.',
            'direction.in' => 'Invalid sorting direction.',
        ];
    }

    // Method to get user IDs as a comma-separated string.
    protected function getUserIdsString(): string
    {
        return implode(',', User::pluck('id')->toArray());
    }
}
