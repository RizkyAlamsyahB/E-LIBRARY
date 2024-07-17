<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
           'phone' => ['nullable', 'string', 'max:14'],
           'department' => ['nullable', 'string', 'max:225'],
           'date_of_birth' => ['nullable', 'date'],
           'address' => ['nullable', 'string', 'max:225'],
           'gender' => ['nullable', 'string', Rule::in(['male', 'female'])],
           'marital_status' => ['nullable', 'string', Rule::in(['single', 'married'])],
           'photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }
}