<?php

use App\Models\Package;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
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



// User dashboard
Route::group((['prefix' => 'user', 'middleware' => ['web', 'auth']]), function () {
    Route::get('/dashboard', [App\Http\Controllers\UserController::class, 'redirectDash'])->name('user.dashboard')->middleware('approval');
    Route::post('/checkout',[App\Http\Controllers\UserController::class,'checkout'])->name('user.checkout');
    Route::get('/success', [App\Http\Controllers\UserController::class,'success'])->name('success');
    Route::post('/profile_details',[App\Http\Controllers\UserController::class,'profile_details'])->name('profile_details');
    Route::get('/user_details_info',[App\Http\Controllers\UserController::class,'user_details_info'])->name('user_details_info');

});
Route::get('/logout',[App\Http\Controllers\UserController::class,'logout'])->name('user.logout');

//Admin dashboard
Route::group((['prefix' => 'admin', 'middleware' => ['web', 'auth']]), function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'redirectDash'])->name('admin.dashboard');
    Route::get('/management',[App\Http\Controllers\AdminController::class,'management'])->name('admin.user_management');
    Route::post('/approve/{id}',[App\Http\Controllers\AdminController::class,'approve'])->name('user.approve');
    Route::get('/package_management',function(){
        return view('pages.package');
    })->name('admin.package_management');
    Route::get('/package_lists',[App\Http\Controllers\PackageController::class,'package_lists'] )->name('admin.package_lists');
    Route::get('/package_edit/{id}',[App\Http\Controllers\PackageController::class,'package_edit'] )->name('admin.package_edit');
    Route::get('/package_delete/{id}',[App\Http\Controllers\PackageController::class,'package_delete'])->name('admin.package_delete');
    Route::post('/package_update',[App\Http\Controllers\PackageController::class,'package_update'])->name('admin.package_update');
    Route::post('/package_upload',[App\Http\Controllers\PackageController::class,'package_upload'])->name('admin.package_post');

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


