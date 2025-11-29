<?php

namespace App\Http\Requests\Api\Dropdown;

use App\Enums\General\DropdownOptionEnum;
use App\Enums\General\StatusEnum;
use App\Exceptions\ValidationException;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class DropdownRequest extends BaseRequest
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
        return [];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(DropdownOptionEnum::values()->toArray())],
            'is_decrypted' => ['nullable', 'boolean'],
            'status' => ['nullable', Rule::in(StatusEnum::values()->toArray())],
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
