<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;

Route::middleware('guest')->group(function ($router) {
    $router->get('register', [RegisteredUserController::class, 'create'])->name('register');
    $router->post('register', [RegisteredUserController::class, 'store']);

    $router->get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    $router->post('login', [AuthenticatedSessionController::class, 'store']);

    $router->get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    $router->post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    $router->get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    $router->post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware('auth')->group(function ($router) {
    $router->get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');

    $router->get('verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed', 'throttle:6,1'])->name('verification.verify');

    $router->post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware('throttle:6,1')->name('verification.send');

    $router->get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    $router->post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    $router->post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
