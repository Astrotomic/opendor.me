<?php

use App\Http\Policies\PermissionsPolicy;

return [
    /*
     * A policy will determine which Feature-Policy headers will be set.
     * A valid policy extends `Mazedlx\FeaturePolicy\Policies\Policy`
     */
    'policy' => PermissionsPolicy::class,

    /*
     * Feature-policy headers will only be added if this is set to true
     */
    'enabled' => env('FPH_ENABLED', true),
];
