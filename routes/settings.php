<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\PasswordController;

Route::middleware('auth')->group(function ($router) {
    $router->redirect('settings', '/settings/profile');

    $router->get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    $router->patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    $router->delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    $router->get('settings/password', [PasswordController::class, 'edit'])->name('password.edit');
    $router->put('settings/password', [PasswordController::class, 'update'])->name('password.update');

    $router->get('settings/appearance', fn () => Inertia::render('settings/Appearance'))->name('appearance');
});
