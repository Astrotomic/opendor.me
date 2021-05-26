<?php

namespace App\View\Components\Card;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Repository extends Component
{
    public function __construct(
        public \App\Models\Repository $repository,
        public ?User $user = null
    ) {
        if ($this->user === null || ! $this->user->exists) {
            $this->user = null;
        }
    }

    public function render(): View
    {
        return view('components.card.repository');
    }
}
