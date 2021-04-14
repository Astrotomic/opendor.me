<?php

namespace App\View\Components\Card;

use App\Models\User;
use App\View\Concerns\CachedView;
use Carbon\CarbonInterval;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Repository extends Component
{
    use CachedView;

    public function __construct(
        public \App\Models\Repository $repository,
        public ?User $user = null
    ) {
        if ($this->user === null || ! $this->user->exists) {
            $this->user = null;
        }

        $this->ttl = CarbonInterval::minutes(15);
    }

    protected function view(): View
    {
        return view('components.card.repository');
    }
}
