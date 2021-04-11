<?php

return [

    'default' => 'md',

    'drivers' => [
        'md' => \Orbit\Drivers\Markdown::class,
        'json' => \Orbit\Drivers\Json::class,
        'yaml' => \Orbit\Drivers\Yaml::class,
    ],

    'paths' => [
        'content' => base_path('content'),
        'cache' => storage_path('framework/cache/orbit'),
    ],

    'git' => [
        'enabled' => false,
        'name' => env('ORBIT_GIT_NAME'),
        'email' => env('ORBIT_GIT_EMAIL'),
        'root' => env('ORBIT_GIT_ROOT', base_path()),
        'binary' => env('ORBIT_GIT_BINARY', '/usr/bin/git'),
    ],

];
