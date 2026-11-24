<?php

use Orbit\Drivers\Json;
use Orbit\Drivers\Markdown;
use Orbit\Drivers\Yaml;

return [

    'default' => 'md',

    'drivers' => [
        'md' => Markdown::class,
        'json' => Json::class,
        'yaml' => Yaml::class,
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
