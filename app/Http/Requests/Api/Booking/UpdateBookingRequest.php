<?php

namespace App\Http\Requests\Api\Booking;

use App\Enums\Booking\BookingStatusEnum;
use App\Exceptions\ValidationException;
use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdateBookingRequest extends BaseRequest
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
        return ['id', 'service_id'];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();

        // Convert booking_date from user format to database format
        if ($this->has('booking_date')) {
            $this->merge([
                'booking_date' => formatDateForDatabase($this->booking_date),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:bookings,id'],
            'service_id' => ['sometimes', 'required', 'integer', 'exists:services,id,is_active,1'],
            'client_name' => ['sometimes', 'required', 'string', 'max:255'],
            'client_email' => ['sometimes', 'required', 'email', 'max:255'],
            'client_phone' => ['sometimes', 'required', 'string', 'max:20'],
            'booking_date' => ['sometimes', 'required', 'date', 'after_or_equal:today'],
            'start_time' => ['sometimes', 'required', 'date_format:H:i'],
            'status' => ['sometimes', 'required', Rule::enum(BookingStatusEnum::class)],
            'notes' => ['nullable', 'string', 'max:500'],
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
