<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\WebsiteController;

Route::middleware(['auth:sanctum'])->group(function ($router) {
    $router->get('/websites', [WebsiteController::class, 'list']);
    $router->post('/save-website', [WebsiteController::class, 'save']);
    $router->get('/website/{id}', [WebsiteController::class, 'getWebsite']);
    $router->delete('/delete-website/{id}', [WebsiteController::class, 'delete']);
    $router->get('/load-website', [WebsiteController::class, 'load']);
    $router->post('/upload-image', [WebsiteController::class, 'uploadImage']);
});
