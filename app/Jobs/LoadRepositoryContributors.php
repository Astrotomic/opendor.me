<?php

namespace App\Jobs;

use App\Models\Repository;
use Carbon\CarbonInterval;
use Illuminate\Support\Collection;

class LoadRepositoryContributors extends GithubJob
{
    public function __construct(protected Repository $repository)
    {
        parent::__construct();
        $this->timeout = CarbonInterval::minutes(5)->totalSeconds;
    }

    public function run(): void
    {
        $this->paginated(function (int $page, int $perPage): Collection {
            $response = $this->repository->github()->get("/repos/{$this->repository->name}/contributors", [
                'anon' => true,
                'per_page' => $perPage,
                'page' => $page,
            ])->collect();

            $this->batch()->add($response->map(function (array $contributor): AddRepositoryContributor {
                return new AddRepositoryContributor($this->repository, $contributor);
            }));

            return $response;
        });
    }
}
