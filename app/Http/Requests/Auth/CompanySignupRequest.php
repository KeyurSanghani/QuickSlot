<?php

namespace App\Http\Requests\Auth;

use App\Exceptions\ValidationException;
use App\Rules\IndianPhoneNumber;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CompanySignupRequest extends FormRequest
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
            // --- Company Information Rules ---
            'company_name' => ['required', 'string', 'max:255'],
            'company_email' => ['required', 'string', 'email', 'max:255', 'unique:companies,email'],
            'company_contact' => ['nullable', 'string', new IndianPhoneNumber],
            'company_website' => ['nullable', 'string', 'url', 'max:255'],
            'company_address' => ['nullable', 'string', 'max:1000'],

            // --- Admin Account Details Rules ---
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'user_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'user_contact' => ['nullable', 'string', new IndianPhoneNumber],
            'password' => ['required', 'string', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],

            // --- Terms & Conditions ---
            'terms' => ['accepted'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'company_contact.indian_phone_number' => 'The company contact must be a valid Indian phone number.',
            'user_contact.indian_phone_number' => 'The user contact must be a valid Indian phone number.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException($validator);
    }
}
