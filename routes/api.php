<?php

use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthUserController::class, 'login']);
Route::post('auth/logout', [AuthUserController::class, 'logout'])
    ->middleware('auth:sanctum');

// User API Routes
Route::apiResources([
    'users' => UserController::class,
], [
    'middleware' => ['throttle:api', 'auth:sanctum'],
    'except' => ['store', 'update', 'destroy'],
    'names' => [
        'index' => 'api.users.index',
        'show' => 'api.users.show',
    ],
]);
