<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
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

Route::get('/', function () {
    return "Welcome back Martin Nguyen";
});

/*---------------------------------------------------ADMIN-----------------------------------------------------------------*/

Route::get('home-page', [HomeController::class, 'index'])->name('admin.home');
Route::resource('users', UserController::class);
Route::post('delete-all-user', [UserController::class, 'deleteAll'])->name('users.delete_all');
