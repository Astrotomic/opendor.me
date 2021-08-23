<?php

namespace App\Jobs;

use App\Models\Repository;
use App\Models\User;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;

class SyncUserContributions extends GithubJob
{
    public function __construct(protected User $user)
    {
        parent::__construct();
        $this->timeout = CarbonInterval::minutes(5)->totalSeconds;
    }

    public function run(): void
    {
        if (! $this->user->hasGithubToken()) {
            return;
        }

        $end = CarbonImmutable::now();
        do {
            $start = $end->subMonths(3);

            $response = $this->user->github()->post('/graphql', [
                'query' => $this->query(),
                'variables' => [
                    'from' => $start->startOfDay()->toIso8601ZuluString(),
                    'to' => $end->endOfDay()->toIso8601ZuluString(),
                ],
            ])->json('data.viewer.contributionsCollection');

            foreach (data_get($response, 'commitContributionsByRepository.*.repository.nameWithOwner') as $name) {
                $repository = Repository::fromName($name);

                if ($repository === null) {
                    continue;
                }

                $repository->contributors()->syncWithoutDetaching($this->user);
            }

            $end = $start;
        } while ($response['hasActivityInThePast']);

        $this->user->touch();
    }

    protected function query(): string
    {
        return <<<'QUERY'
        query(
          $from: DateTime,
          $to: DateTime
        ) {
          viewer {
            contributionsCollection(from: $from, to: $to) {
              hasActivityInThePast
              commitContributionsByRepository(maxRepositories: 100) {
                repository {
                  nameWithOwner
                }
              }
              pullRequestContributionsByRepository(maxRepositories: 100) {
                repository {
                  nameWithOwner
                }
              }
            }
          }
        }
        QUERY;
    }
}
