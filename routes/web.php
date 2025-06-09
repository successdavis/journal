<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthorController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/author/dashboard', function () {
    return Inertia::render('Author/Dashboard');
})->middleware(['auth', 'verified'])
    ->name('author.dashboard');

Route::get('/editor/dashboard', function () {
    return Inertia::render('Editor/Dashboard');
})->middleware(['auth', 'verified'])
    ->name('editor.dashboard');

Route::get('/reviewer/dashboard', function () {
    return Inertia::render('Reviewer/Dashboard');
})->middleware(['auth', 'verified'])
    ->name('reviewer.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/author/my-submissions', [AuthorController::class, 'index']);
    Route::get('/author/submit-new-manuscript', [AuthorController::class, 'create']);
    Route::post('/author/submit-new-manuscript', [AuthorController::class, 'store']);
});

require __DIR__ . '/auth.php';
