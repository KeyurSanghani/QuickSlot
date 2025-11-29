<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class BaseRequest extends FormRequest
{
    /**
     * Fields that should be decrypted.
     */
    protected function decryptableFields(): array
    {
        return [];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->decryptFields($this->decryptableFields());
    }

    /**
     * Decrypt specified fields in the request data.
     *
     * @param  array  $fields  Array of field paths to decrypt (supports dot notation)
     */
    protected function decryptFields(array $fields): void
    {
        $data = $this->all();

        foreach ($fields as $field) {
            if ($this->shouldDecryptField($field, $data)) {
                $data = $this->performDecryption($field, $data);
            }
        }

        $this->replace($data);
    }

    /**
     * Check if a field should be decrypted.
     */
    private function shouldDecryptField(string $field, array $data): bool
    {
        // Handle wildcard patterns like 'product_attributes.*.id'
        if (str_contains($field, '*')) {
            return $this->hasWildcardMatch($field, $data);
        }

        // Handle regular dot notation
        return Arr::has($data, $field);
    }

    /**
     * Check if there are any matches for wildcard patterns.
     */
    private function hasWildcardMatch(string $pattern, array $data): bool
    {
        $keys = $this->expandWildcardPattern($pattern, $data);

        return ! empty($keys);
    }

    /**
     * Perform the actual decryption on the field.
     */
    private function performDecryption(string $field, array $data): array
    {
        if (str_contains($field, '*')) {
            return $this->decryptWildcardField($field, $data);
        }

        return $this->decryptSingleField($field, $data);
    }

    /**
     * Decrypt a single field using dot notation.
     */
    private function decryptSingleField(string $field, array $data): array
    {
        $value = Arr::get($data, $field);

        if ($value !== null && $value !== '') {
            $decryptedValue = $this->decryptValue($value);
            Arr::set($data, $field, $decryptedValue);
        }

        return $data;
    }

    /**
     * Decrypt fields that match a wildcard pattern.
     */
    private function decryptWildcardField(string $pattern, array $data): array
    {
        $keys = $this->expandWildcardPattern($pattern, $data);

        foreach ($keys as $key) {
            $value = Arr::get($data, $key);

            if ($value !== null && $value !== '') {
                $decryptedValue = $this->decryptValue($value);
                Arr::set($data, $key, $decryptedValue);
            }
        }

        return $data;
    }

    /**
     * Expand wildcard pattern to actual array keys.
     */
    private function expandWildcardPattern(string $pattern, array $data): array
    {
        $keys = [];
        $parts = explode('.', $pattern);
        $this->findMatchingKeys($data, $parts, 0, '', $keys);

        return $keys;
    }

    /**
     * Recursively find keys that match the wildcard pattern.
     */
    private function findMatchingKeys(array $data, array $parts, int $index, string $currentPath, array &$keys): void
    {
        if ($index >= count($parts)) {
            return;
        }

        $part = $parts[$index];
        $isLast = $index === count($parts) - 1;

        if ($part === '*') {
            // Handle wildcard
            foreach ($data as $key => $value) {
                $newPath = $currentPath === '' ? $key : $currentPath.'.'.$key;

                if ($isLast) {
                    $keys[] = $newPath;
                } elseif (is_array($value)) {
                    $this->findMatchingKeys($value, $parts, $index + 1, $newPath, $keys);
                }
            }
        } else {
            // Handle regular key
            if (isset($data[$part])) {
                $newPath = $currentPath === '' ? $part : $currentPath.'.'.$part;

                if ($isLast) {
                    $keys[] = $newPath;
                } elseif (is_array($data[$part])) {
                    $this->findMatchingKeys($data[$part], $parts, $index + 1, $newPath, $keys);
                }
            }
        }
    }

    /**
     * Decrypt a single value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    private function decryptValue($value)
    {
        try {
            return decryption($value);
        } catch (\Exception $e) {
            return $value; // Return original value if decryption fails
        }
    }

    /**
     * Decrypt array keys at the specified path(s).
     *
     * @param  string|array  $paths  Dot notation path(s) to the array
     */
    protected function decryptArrayKeys(string|array $paths): void
    {
        $paths = is_array($paths) ? $paths : [$paths];

        foreach ($paths as $path) {
            $data = $this->all();
            $arr = Arr::get($data, $path);

            if (is_array($arr)) {
                $rebuilt = [];
                foreach ($arr as $k => $v) {
                    $newK = $this->decryptValue($k);
                    $rebuilt[$newK] = $v;
                }
                Arr::set($data, $path, $rebuilt);
                $this->replace($data);
            }
        }
    }

    /**
     * Decrypt all values in an array at the specified path(s).
     *
     * @param  string|array  $paths  Dot notation path(s) to the array
     */
    protected function decryptArray(string|array $paths): void
    {
        $paths = is_array($paths) ? $paths : [$paths];

        foreach ($paths as $path) {
            $data = $this->all();
            $arr = Arr::get($data, $path);

            if (is_array($arr)) {
                $decrypted = [];
                foreach ($arr as $k => $v) {
                    if ($v !== null && $v !== '') {
                        $decrypted[$k] = $this->decryptValue($v);
                    } else {
                        $decrypted[$k] = $v;
                    }
                }
                Arr::set($data, $path, $decrypted);
                $this->replace($data);
            }
        }
    }
}
