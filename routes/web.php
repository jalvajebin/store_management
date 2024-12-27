<?php

use App\Http\Controllers\Admin\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\Web\LoginController::class, 'index'])->name('login.index');
Route::post('/', [\App\Http\Controllers\Web\LoginController::class, 'store'])->name('login.store');

Route::resource('register', \App\Http\Controllers\Web\RegisterController::class)->only('index', 'store');

Route::resource('home', \App\Http\Controllers\Web\HomeController::class)
    ->only('index')
    ->middleware('auth');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('login', \App\Http\Controllers\Admin\LoginController::class)->only('index', 'store')->middleware('admin.guest');

    Route::middleware('auth:admin')->group(function () {
        Route::resource('dashboard', \App\Http\Controllers\Admin\DashboardController::class)->only('index');
        Route::resource('logout', \App\Http\Controllers\Admin\LogoutController::class)->only('store');
        Route::resource('stores', StoreController::class)->except('show');

    });
});

