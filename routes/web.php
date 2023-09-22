<?php

use App\Http\Controllers\Admin\CreateController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\ListController;
use App\Http\Controllers\Frontend\QuizController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

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
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::middleware(['user-access:admin'])->group(function () {
        Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
        Route::resource('/admin', CreateController::class);
    });
    Route::get('/home', [ListController::class, 'index'])->name('home');
    Route::resource('/student/quiz', QuizController::class);
    Route::get('/logout', [LoginController::class,'logout'])->name('logout.user');
});