<?php

use App\Http\Controllers\Admin\OrganizationCrudController;
use App\Http\Controllers\Admin\RepositoryCrudController;
use App\Http\Controllers\Admin\UserCrudController;

Route::prefix(config('backpack.base.route_prefix', 'admin'))->middleware(array_merge((array) config('backpack.base.web_middleware', 'web'), (array) config('backpack.base.middleware_key', 'admin')))->group([
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
], function () {
    Route::crud('user', UserCrudController::class);
    Route::crud('organization', OrganizationCrudController::class);
    Route::crud('repository', RepositoryCrudController::class);
});
