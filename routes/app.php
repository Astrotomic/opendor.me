<?php

use App\Models\Repository;
use Illuminate\Support\Facades\Route;

Route::get('contributions', function () {
    return view('app.contributions', [
        'contributions' => auth()->user()->contributions->load('owner'),
    ]);
})->name('contributions');

Route::post('repository', function (Illuminate\Http\Request $request) {
    Repository::fromName($request->input('name'));

    return redirect()->back();
})->name('repository.create');
