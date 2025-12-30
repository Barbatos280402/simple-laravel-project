<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

Route::get('/docker-test', function () {
    return response()->json([
        'message' => 'Laravel is running in Docker!',
        'database' => DB::connection()->getPdo() ? 'Connected' : 'Disconnected',
        'cache' => Cache::get('test') ?: 'Cache working',
        'timestamp' => now()->toISOString(),
    ]);
});

require __DIR__ . '/settings.php';
