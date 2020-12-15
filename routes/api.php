<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\MovieController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Authentication routes
Route::group([
    'middleware' => 'api',
    'prefix'     => 'auth'
], function ($router) {
    Route::post('/login',        [AuthController::class, 'login'])   ->name('login_api');
    Route::post('/logout',       [AuthController::class, 'logout'])  ->name('logout_api');
    Route::post('/registration', [AuthController::class, 'register'])->name('registration_api');
});

// REST API morror routes
Route::group(['middleware' => 'api'], function ($router) {
    Route::get('/getBook',  [BookController::class, 'handle']) ->name('book_api');
    Route::get('/getMovie', [MovieController::class, 'handle'])->name('movie_api');
});
