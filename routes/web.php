<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::get('/', fn () => redirect('/login'))->name('home');

Route::get('dashboard', fn () => Inertia::render('Dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('websites', fn () => Inertia::render('Website'))
    ->middleware(['auth', 'verified'])
    ->name('websites');
