<?php

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\Route;

Route::get('contributions', static function (): ViewContract {
    return view('app.contributions', [
        'user' => auth()->user(),
        'contributions' => auth()->user()->contributions()->with('owner')->cursor(),
    ]);
})->name('contributions');
