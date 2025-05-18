<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/websites', [\App\Http\Controllers\WebsiteBuilderController::class, 'list']);
    Route::post('/save-website', [\App\Http\Controllers\WebsiteBuilderController::class, 'save']);
    Route::get('/website/{id}', [\App\Http\Controllers\WebsiteBuilderController::class, 'getWebsite']);
    Route::delete('/delete-website/{id}', [\App\Http\Controllers\WebsiteBuilderController::class, 'delete']);
    Route::get('/load-website', [\App\Http\Controllers\WebsiteBuilderController::class, 'load']);
    Route::post('/upload-image', [\App\Http\Controllers\WebsiteBuilderController::class, 'uploadImage']);
});
