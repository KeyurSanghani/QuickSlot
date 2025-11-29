<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class CacheService
{
    public static function validIds()
    {
        return [
            '',
        ];
    }

    public static function getModelData($id, $forceNew = false, $ttl = 3600): mixed
    {
        if ($forceNew) {
            self::forgetModelData($id);
        }

        return Cache::remember($id, $ttl, function () use ($id) {
            switch ($id) {
                default:
                    return null;
            }
        });
    }

    public static function cacheAllModelData(): void
    {
        foreach (self::validIds() as $id) {
            self::getModelData($id, true);
        }
    }

    public static function forgetAllModelData(): void
    {
        foreach (self::validIds() as $id) {
            self::forgetModelData($id);
        }
    }

    public static function forgetModelData($id): void
    {
        Cache::forget($id);
    }
}
