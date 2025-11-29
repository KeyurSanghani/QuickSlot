<?php

namespace App\Helpers;

/**
 * API Version Helper
 *
 * Provides utility methods for working with API versions
 */
class ApiVersionHelper
{
    /**
     * Get the current API version
     */
    public static function getCurrentVersion(): string
    {
        return config('api.current_version');
    }

    /**
     * Get all supported API versions
     */
    public static function getSupportedVersions(): array
    {
        return config('api.supported_versions');
    }

    /**
     * Check if a version is supported
     */
    public static function isVersionSupported(string $version): bool
    {
        return in_array($version, self::getSupportedVersions());
    }

    /**
     * Get the full API URL for a given endpoint and version
     *
     * @param  string  $endpoint  The API endpoint (without /api prefix)
     * @param  string|null  $version  The API version (defaults to current)
     */
    public static function getApiUrl(string $endpoint, ?string $version = null): string
    {
        $version = $version ?? self::getCurrentVersion();
        $endpoint = ltrim($endpoint, '/');

        return url("/api/{$version}/{$endpoint}");
    }

    /**
     * Get deprecation information
     */
    public static function getDeprecationInfo(): array
    {
        return [
            'url' => config('api.deprecation_url'),
            'current_version' => self::getCurrentVersion(),
            'supported_versions' => self::getSupportedVersions(),
        ];
    }

    /**
     * Check if strict versioning is enabled
     */
    public static function isStrictVersioning(): bool
    {
        return config('api.strict_versioning', true);
    }
}
