<?php

use Illuminate\Support\Facades\Route;
use Modules\User\App\Http\Controllers\UserAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'prefix' => 'auth',
], function () {
    Route::get('register', [UserAuthController::class, 'registerForm'])->name('register.form');
    Route::post('register', [UserAuthController::class, 'register'])->name('register');
    Route::get('login', [UserAuthController::class, 'loginForm'])->name('login.form');
    Route::post('login', [UserAuthController::class, 'login'])->name('login');
});
