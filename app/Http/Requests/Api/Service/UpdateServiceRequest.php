<?php

namespace App\Http\Requests\Api\Service;

use App\Exceptions\ValidationException;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;

class UpdateServiceRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Fields that should be decrypted.
     */
    protected function decryptableFields(): array
    {
        return ['id'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:services,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'duration' => ['sometimes', 'required', 'integer', 'min:15', 'max:480'],
            'price' => ['sometimes', 'required', 'numeric', 'min:0', 'max:999999.99'],
            'is_active' => ['nullable', 'boolean'],
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
