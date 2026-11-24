<?php

return [
    'path' => env('FILAMENT_PATH', 'admin'),
    'domain' => env('FILAMENT_DOMAIN'),
    'brand' => env('APP_NAME', 'opendor.me'),
    'auth_guard' => env('FILAMENT_AUTH_GUARD', 'web'),
    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DRIVER', 'public'),
];
