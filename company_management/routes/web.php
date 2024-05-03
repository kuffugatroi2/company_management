<?php

use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PersonController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TaskController;
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

        // project
        Route::resource('projects', ProjectController::class);
        Route::post('delete-all-project', [ProjectController::class, 'deleteAll'])->name('projects.delete_all');
        Route::get('persons-ajax/{idCompany}/{idProject}', [ProjectController::class, 'getPerson']);

        // task
        Route::resource('tasks', TaskController::class);
        Route::post('delete-all-task', [TaskController::class, 'deleteAll'])->name('tasks.delete_all');
        Route::get('tasks-ajax/{idProject}', [TaskController::class, 'getPerson']);
        Route::get('export', [TaskController::class, 'export'])->name('tasks.export');
    });
});
