<?php

namespace App\Nova\Metrics;

use App\Models\User;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\ValueResult;

class RegisteredUsers extends Value
{
    public function calculate(NovaRequest $request): ValueResult
    {
        return $this->count($request, User::query()->whereNotNull('github_access_token'));
    }

    public function ranges(): array
    {
        return [
            'ALL' => __('All'),
        ];
    }
}
