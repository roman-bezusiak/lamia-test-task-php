<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebViews\IndexViewController;
use App\Http\Controllers\WebViews\Auth\RegistrationViewController;
use App\Http\Controllers\WebViews\Auth\LoginViewController;
use App\Http\Controllers\WebViews\Search\BookSearchViewController;
use App\Http\Controllers\WebViews\Search\MovieSearchViewController;
use App\Http\Controllers\WebViews\FallbackViewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/',             [IndexViewController::class, 'handle'])       ->name('index_page');
Route::get('/login',        [LoginViewController::class, 'handle'])       ->name('login_page');
Route::get('/registration', [RegistrationViewController::class, 'handle'])->name('registration_page');

Route::group(['prefix' => 'search'], function ($router) {
    Route::get('/book',  [BookSearchViewController::class, 'handle']) ->name('book_search_page');
    Route::get('/movie', [MovieSearchViewController::class, 'handle'])->name('movie_search_page');
});

Route::fallback([FallbackViewController::class, 'handle']);
