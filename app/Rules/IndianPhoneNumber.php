<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IndianPhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Remove all non-digit characters for validation
        $cleanedNumber = preg_replace('/[^0-9]/', '', $value);

        // Check if it's a valid Indian phone number
        if (! $this->isValidIndianPhoneNumber($cleanedNumber)) {
            $fail(__('validation.indian_phone_number'));
        }
    }

    /**
     * Check if the phone number is a valid Indian phone number.
     */
    private function isValidIndianPhoneNumber(string $number): bool
    {
        // Indian mobile numbers: 10 digits starting with 6-9
        // With country code: +91 followed by 10 digits
        // Landline: 10-11 digits with area codes

        // Remove country code if present
        if (str_starts_with($number, '91') && strlen($number) === 12) {
            $number = substr($number, 2);
        }

        // Check for 10-digit mobile numbers starting with 6, 7, 8, or 9
        if (strlen($number) === 10 && preg_match('/^[6-9][0-9]{9}$/', $number)) {
            return true;
        }

        // Check for 11-digit landline numbers (with area code)
        if (strlen($number) === 11 && preg_match('/^[0-9]{2,4}[0-9]{6,8}$/', $number)) {
            return true;
        }

        // Check for 10-digit landline numbers
        if (strlen($number) === 10 && preg_match('/^[0-9]{2,4}[0-9]{6,8}$/', $number)) {
            return true;
        }

        return false;
    }
}
