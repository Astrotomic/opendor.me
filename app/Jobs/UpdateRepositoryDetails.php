<?php

namespace App\Jobs;

use App\Enums\Language;
use App\Enums\License;
use App\Models\Repository;

class UpdateRepositoryDetails extends GithubJob
{
    public function __construct(
        protected Repository $repository
    ) {
        parent::__construct();
    }

    public function run(): void
    {
        $data = $this->repository->github()->get("/repositories/{$this->repository->id}")->json();

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
