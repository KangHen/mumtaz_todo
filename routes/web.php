<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/welcome', function () {
        return Inertia::render('Dashboard');
    })->name('welcome');

    Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');
    Route::resource('task', TaskController::class)->except(['index', 'show']);
    Route::post('comment', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('comment/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');
});
