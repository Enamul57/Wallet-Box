<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');
//admin login register
Route::prefix('admin')->group(function () {
    Route::get('/login', function () {
        return view('admin.admin_login');
    })->name('admin_login.get');

    Route::get('/register', function () {
        return view('admin.admin_register');
    })->name('admin_register.get');

    Route::post('/register', [App\Http\Controllers\AdminController::class, 'register'])->name('admin_register.post');
    Route::post('/login', [App\Http\Controllers\AdminController::class, 'login'])->name('admin_login.post');

});
//dashboard
Route::group((['prefix' => 'user', 'middleware' => ['web', 'auth']]), function () {
    Route::get('/dashboard', [App\Http\Controllers\UserController::class, 'redirectDash'])->name('user.dashboard')->middleware('approval');

});
Route::get('/logout',[App\Http\Controllers\UserController::class,'logout'])->name('user.logout');
Route::group((['prefix' => 'admin', 'middleware' => ['web', 'auth']]), function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'redirectDash'])->name('admin.dashboard');
    Route::get('/management',[App\Http\Controllers\AdminController::class,'management'])->name('admin.user_management');
    Route::post('/approve/{id}',[App\Http\Controllers\AdminController::class,'approve'])->name('user.approve');
});
//user login register
Route::group((['prefix' => 'user']), function () {
    Route::get('/login', function () {
        return view('user.user_login');
    })->name('user_login.get');
    Route::post('/login', [App\Http\Controllers\UserController::class, 'login'])->name('user_login.post');
    Route::post('/register', [App\Http\Controllers\UserController::class, 'register'])->name('user_register.post');
    Route::get('/register', function () {
        return view('user.user_register');
    })->name('user_register.get');
});

//
