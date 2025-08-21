<?php

return [
    'service_account_credentials' => [
        'project_id' => env('GOOGLE_PLAY_PROJECT_ID'),
        'client_id' => env('GOOGLE_PLAY_CLIENT_ID'),
        'client_email' => env('GOOGLE_PLAY_CLIENT_EMAIL'),
        'private_key' => env('GOOGLE_PLAY_CLIENT_SECRET'),
        'client_secret' => env('GOOGLE_PLAY_CLIENT_SECRET'),
        // 'client_secret' => env('GOOGLE_PLAY_CLIENT_SECRET'),
    ],
    "PACKAGE_NAME" => env('GOOGLE_PLAY_PACKAGE_NAME')
];