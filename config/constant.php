<?php

return [

    // Default value
    'FILESYSTEM_DISK' => env('FILESYSTEM_DISK', 'public'),
    'DEFAULT_PER_PAGE' => 10,
    'DEFAULT_AWS_S3_BUCKET_FOLDER_NAME' => env('AWS_S3_BUCKET_FOLDER_NAME', 'quick-slot'),
    'USER_PROFILE_IMAGE_PATH' => 'users/<user_id>/',
    'COMPANY_LOGO_IMAGE_PATH' => 'logo/',
    'PROFILE_IMAGE_PATH' => 'contacts/profiles/',
    'DOCUMENT_FILE_PATH' => 'contacts/documents/',

    // Date format indian
    'DEFAULT_DATE_TIME_FORMAT' => 'd-m-Y h:i A',

    'DEFAULT_SYSTEM_ROLES' => [
        [
            'slug' => 'super-admin',
            'title' => 'Super Admin',
        ],
    ],

    'SUPER_ADMIN_ROLE_SLUG' => 'super-admin',

    // Default Format
    'DEFAULT_DATABASE_DATE_FORMAT' => 'Y-m-d',
    'DEFAULT_DATABASE_TIME_FORMAT' => 'H:i:s',
    'DEFAULT_DATABASE_DATE_TIME_FORMAT' => 'Y-m-d H:i:s',

    // User Format
    'DEFAULT_DATE_FORMAT' => 'd-m-Y',
    'DEFAULT_TIME_FORMAT' => 'h:i A',
    'DEFAULT_DATE_TIME_FORMAT' => 'd-m-Y h:i A',
];
