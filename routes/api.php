<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DomainsController;
use App\Http\Controllers\ServersController;
use App\Http\Controllers\StaticController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', [StaticController::class, 'main']);
Route::post('/auth/token', [AuthController::class, 'token']);

Route::middleware('auth:sanctum')->group(static function (): void {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::delete('/auth/logout', [AuthController::class, 'destroy']);

    Route::apiResource('servers', ServersController::class);
    Route::apiResource('domains', DomainsController::class);
});
