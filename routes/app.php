<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\View\View as ViewContract;

Route::get('contributions', static function (): ViewContract {
    return view('app.contributions', [
        'contributions' => auth()->user()->contributions->load('owner'),
    ]);
})->name('contributions');
