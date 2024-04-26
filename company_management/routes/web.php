<?php

use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PersonController;
use App\Http\Controllers\Admin\RoleController;
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

Route::get('/', [AuthenticationController::class, 'index'])->name('login');
Route::post('login', [AuthenticationController::class, 'login'])->name('admin_authentication.login');
Route::get('logout', [AuthenticationController::class, 'logout'])->name('admin_authentication.logout');

/*---------------------------------------------------ADMIN-----------------------------------------------------------------*/

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('home-page', [HomeController::class, 'index'])->name('admin.home_page');

        // User
        Route::resource('users', UserController::class);
        Route::post('delete-all-user', [UserController::class, 'deleteAll'])->name('users.delete_all');

        // Company
        Route::resource('companies', CompanyController::class);
        Route::post('delete-all-company', [CompanyController::class, 'deleteAll'])->name('companies.delete_all');

        // Person
        Route::resource('persons', PersonController::class);
        Route::post('delete-all-person', [PersonController::class, 'deleteAll'])->name('persons.delete_all');

        // Role
        Route::resource('roles', RoleController::class);
        Route::post('delete-all-role', [RoleController::class, 'deleteAll'])->name('roles.delete_all');

        // Department
        Route::resource('departments', DepartmentController::class);
        Route::post('delete-all-department', [DepartmentController::class, 'deleteAll'])->name('departments.delete_all');
    });
});
