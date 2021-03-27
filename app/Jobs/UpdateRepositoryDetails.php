<?php

namespace App\Jobs;

use App\Enums\Language;
use App\Enums\License;
use App\Models\Repository;
use Carbon\CarbonInterval;

class UpdateRepositoryDetails extends GithubJob
{
    public function __construct(protected Repository $repository)
    {
        parent::__construct();
        $this->timeout = CarbonInterval::minutes(5)->totalSeconds;
    }

    public function run(): void
    {
        $data = $this->repository->github()->get("/repos/{$this->repository->name}")->json();

        $this->repository->fill([
            'description' => $data['description'],
            'stargazers_count' => $data['stargazers_count'],
            'website' => $data['homepage'],
        ]);

        if ($this->repository->language->equals(Language::NOASSERTION())) {
            $this->repository->language = $data['language'] ?? Language::NOASSERTION();
        }

        if ($this->repository->license->equals(License::NOASSERTION())) {
            $this->repository->license = $data['license']['spdx_id'] ?? License::NOASSERTION();
        }

        $this->repository->save();
    }
}
