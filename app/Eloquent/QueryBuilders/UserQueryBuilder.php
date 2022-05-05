<?php

namespace App\Eloquent\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

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
            ->whereNotNull('email_verified_at')
            ->whereNotNull('registered_at');
    }

    public function whereEmail(string $email): self
    {
        return $this->where('email', 'ILIKE', $email);
    }

    public function byEmail(string $email): self
    {
        $email = Str::of($email);

        return $this
            ->whereRaw("emails @> '".json_encode($email)."'")
            ->orWhere('email', $email)
            ->when($email->endsWith('@users.noreply.github.com'), static function (Builder $query) use ($email): void {
                $parts = $email
                    ->beforeLast('@users.noreply.github.com')
                    ->explode('+', 2);

                $query->orWhere(array_filter([
                    'id' => is_numeric($parts[0]) ? $parts[0] : null,
                    'name' => $parts[1] ?? $parts[0],
                ]));
            });
    }
}
