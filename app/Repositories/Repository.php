<?php

namespace App\Repositories;

abstract class Repository
{
    public static function instance(): GithubSponsorRepository
    {
        return app(static::class);
    }
}
