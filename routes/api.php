<?php

use App\Models\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('ping', static function (): JsonResponse {
    return response()->json([
        'ping' => 'pong',
        'env' => config('app.env'),
    ]);
})->name('ping');

Route::get('repository', static function (Request $request) {
    return Repository::query()
        ->with('owner')
        ->when($request->input('contributor'), fn (Builder $query, int $contributor) => $query->whereHas(
            'contributors',
            fn (Builder $q) => $q->whereKey($contributor)
        ))
        ->when($request->input('owner'), fn (Builder $query, array $owner) => $query->whereHasMorph(
            'owner',
            $owner['type'],
            fn (Builder $q) => $q->whereKey($owner['id'])
        ))
        ->orderByDesc('stargazers_count')
        ->paginate(6)
        ->withQueryString();
})->name('repository');
