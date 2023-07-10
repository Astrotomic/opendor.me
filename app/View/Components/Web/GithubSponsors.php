<?php

namespace App\View\Components\Web;

use App\Repositories\GithubSponsorRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class GithubSponsors extends Component
{
    public function __construct(
        protected GithubSponsorRepository $githubSponsorRepository
    ) {
    }

    public function render(): View
    {
        return view('components.web.github-sponsors');
    }

    public function sponsors(): Collection
    {
        return $this->githubSponsorRepository->all();
    }
}
