<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Versioning Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the API versioning configuration for the application.
    | It defines the current version, supported versions, and versioning strategy.
    |
    */

    /**
     * Current stable API version
     */
    'current_version' => 'v1',

    /**
     * All supported API versions
     */
    'supported_versions' => [
        'v1',
        // 'v2', // Add new versions here as they are released
    ],

    /**
     * API versioning strategy
     * Options: 'uri', 'header', 'query'
     */
    'strategy' => 'uri',

    /**
     * API deprecation information URL
     */
    'deprecation_url' => env('API_DEPRECATION_URL', 'https://api-docs.example.com/versioning'),

    /**
     * Default API version to use when version is not specified
     */
    'default_version' => 'v1',

    /**
     * Strict version checking
     * When enabled, only supported versions are allowed
     */
    'strict_versioning' => env('API_STRICT_VERSIONING', true),

];
