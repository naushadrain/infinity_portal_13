<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Routes are stateless and prefixed with /api automatically.
| Auth: add sanctum or passport middleware as needed.
*/

Route::apiResource('users', UsersApiController::class);
