<?php

use App\Http\Controllers\CountController;
use App\Http\Controllers\UserController;
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

Route::prefix('users')->group(function () {
    Route::post('/', [UserController::class, 'create']);
    // GET is not necessary
    // PUT is not necessary
    // DELETE is not necessary
});

Route::prefix('counts')->group(function () {
    Route::post('/', [CountController::class, 'create']);
    Route::get('/{count_uuid}', [CountController::class, 'getCount']);
    Route::put('/{count_uuid}', [CountController::class, 'incrementCount']);
    // DELETE is not necessary
});
