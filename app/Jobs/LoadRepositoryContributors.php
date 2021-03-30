<?php

namespace App\Jobs;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Support\Str;

class LoadRepositoryContributors extends GithubJob
{
    public function __construct(protected Repository $repository)
    {
        parent::__construct();
    }

    public function run(): void
    {
        $page = 1;
        do {
            $response = $this->repository->github()->get("/repos/{$this->repository->name}/contributors", [
                    'anon' => true,
                    'per_page' => 100,
                    'page' => $page,
                ])->collect();

            $contributors = $response->map(function (array $contributor): ?User {
                if ($contributor['type'] === 'User') {
                    return User::fromGithub($contributor);
                } elseif ($contributor['type'] === 'Anonymous') {
                    if (Str::endsWith($contributor['email'], '@users.noreply.github.com')) {
                        $parts = Str::of($contributor['email'])
                            ->beforeLast('@users.noreply.github.com')
                            ->explode('+', 2);

                        $user = User::orWhere([
                            'id' => is_numeric($parts[0]) ? $parts[0] : null,
                            'name' => $parts[1] ?? $parts[0],
                        ])->first();
                    }

                    return $user ?? User::cursor()->first(fn (User $user): bool => in_array($contributor['email'], $user->emails));
                }

                return null;
            })->filter();

            $this->repository->contributors()->syncWithoutDetaching(
                $contributors->pluck('id')
            );

            $page++;
        } while ($response->count() >= 100);
    }
}
