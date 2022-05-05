<?php

namespace App\Eloquent\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class UserQueryBuilder extends Builder
{
    public function whereHasGithubAccessToken(): self
    {
        return $this->whereNotNull('github_access_token');
    }

    public function whereIsRegistered(): self
    {
        return $this
            ->whereHasGithubAccessToken()
            ->whereNotNull('registered_at');
    }
}
