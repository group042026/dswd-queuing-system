<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(\App\Models\User::class)->ignore($this->user()->id),
            ],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique(\App\Models\User::class)->ignore($this->user()->id),
            ],
            'license_number' => [
                'required',
                'string',
                'alpha_num',
                'min:5',
                'max:20',
                Rule::unique(\App\Models\User::class)->ignore($this->user()->id),
            ],
            'contact_number' => ['required', 'string', 'min:7', 'max:15', 'regex:/^\+?[0-9\s\-]+$/'],
            'profile_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,gif', 'max:20480'],
        ];
    }
}
