<?php

namespace App\Http\Controllers\App;

use Illuminate\Contracts\View\View;

class DashboardController
{
    public function __invoke(): View
    {
        return view('app.dashboard');
    }
}
