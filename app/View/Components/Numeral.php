<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Numeral extends Component
{
    public function __construct(
        public string $format = '4a'
    ) {
    }

    public function render(): View
    {
        return view('components.numeral');
    }

    public function numeral($number): string
    {
        return Str::numeral(intval(strval($number)), $this->format);
    }
}
