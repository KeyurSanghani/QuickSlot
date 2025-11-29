<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;

class Enum
{
    /**
     * Get all items.
     */
    public static function all(): Collection
    {
        return static::prepare(
            static::getConstants()
        );
    }

    /**
     * Get values only.
     */
    public static function values(): Collection
    {
        return static::getConstants()->values();
    }

    /**
     * Get keys only.
     */
    public static function keys(): Collection
    {
        return static::getConstants()->keys();
    }

    /**
     * Get key-value array.
     */
    public static function keyValueArray($translated = false, $sort = false, ?array $includedValues = null): array
    {
        $items = self::all()->toArray();
        $data = [];

        if ($sort) {
            $items = array_values(Arr::sort($items, function ($value) {
                return $value['name'];
            }));
        }

        foreach ($items as $item) {
            if (! $includedValues || in_array($item['id'], $includedValues)) {
                $data[($translated ? static::getTranslatedName($item['id']) : $item['id'])] = $item['name'];
            }
        }

        return $data;
    }

    /**
     * Get label-value array to use in dropdowns.
     *
     * @param  array  $exclude  List of enum keys to exclude
     */
    public static function labelValueArray(array $exclude = []): ?array
    {
        $enumKeyValue = self::keyValueArray();

        // Filter out excluded keys
        $filteredEnumKeyValue = array_filter($enumKeyValue, function ($key) use ($exclude) {
            return ! in_array($key, $exclude);
        }, ARRAY_FILTER_USE_KEY);

        return array_map(function ($label, $value) {
            return [
                'label' => $label,
                'value' => $value,
            ];
        }, $filteredEnumKeyValue, array_keys($filteredEnumKeyValue));
    }

    public static function getById($id): ?array
    {
        if (! $id) {
            return null;
        }

        $constant = static::getConstants()->search($id, true);

        if (! $constant) {
            return null;
        }

        return static::prepare(collect([$constant => $id]))->first();
    }

    /**
     * Get list of items by ID.
     *
     * @param  array  $list  List of IDs
     */
    public static function listById(array $ids): array
    {
        $response = [];
        foreach ($ids as $id) {
            $response[] = self::getById($id);
        }

        return $response;
    }

    /**
     * Prepare the response.
     *
     * @param  Collection  $constants  Constants
     */
    protected static function prepare(Collection $constants): Collection
    {
        $data = [];
        foreach ($constants as $constant => $value) {
            $data[] = [
                'id' => $value,
                'name' => static::getTranslatedName($constant),
            ];
        }

        return collect($data);
    }

    /**
     * Get translated name by a constant.
     *
     * @param  string  $constant  Constant
     */
    public static function getTranslatedName(?string $constant): string
    {
        return empty($constant) ? '' : __('enum.'.Str::snake(static::getClassName()).'.'.Str::lower($constant));
    }

    /**
     * Get all constants.
     */
    protected static function getConstants(): Collection
    {
        return collect((new ReflectionClass(static::class))->getConstants());
    }

    /**
     * Get a class name.
     */
    protected static function getClassName(): string
    {
        return (new ReflectionClass(static::class))->getShortName();
    }
}
