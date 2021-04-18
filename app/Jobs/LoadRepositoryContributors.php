<?php

namespace App\Jobs;

use App\Models\Repository;
use App\Models\User;
use Carbon\CarbonInterval;
use Illuminate\Support\Collection;

class LoadRepositoryContributors extends GithubJob
{
    public function __construct(protected Repository $repository)
    {
        parent::__construct();
        $this->timeout = CarbonInterval::hours(4)->totalSeconds;
    }

    public function backoff(): int
    {
        return CarbonInterval::hour()->totalSeconds;
    }

    public function run(): void
    {
        $users = User::all();

        $this->paginated(function (int $page, int $perPage) use ($users): Collection {
            $response = $this->repository->github()->get("/repos/{$this->repository->name}/contributors", [
                'anon' => true,
                'per_page' => $perPage,
                'page' => $page,
            ])->collect();

            $contributors = $response->map(static function (array $contributor) use ($users): ?User {
                if ($contributor['type'] === 'User') {
                    return User::fromGithub($contributor);
                } elseif ($contributor['type'] === 'Anonymous') {
                    $user = User::byEmail($contributor['email'])->first();

                    return $user ?? $users->first(fn (User $user): bool => in_array($contributor['email'], $user->emails));
                }

                return null;
            })->filter();

            $this->repository->contributors()->syncWithoutDetaching(
                $contributors->pluck('id')
            );

            return $response;
        });
    }
}
