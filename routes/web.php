<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TaskController;

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
    return redirect('/admin/login'); // Redirect root to admin login
});

// Admin-specific routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('login');
    Route::post('adminlogin', [LoginController::class, 'adminLogin'])->name('adminLogin');
    Route::get('/reset', [LoginController::class, 'resetpassword'])->name('resetpassword');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    //profile
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::get('/profile/{id}', [LoginController::class, 'profile'])->name('profile');
        Route::put('/profile-update/{id}', [LoginController::class, 'profileUpdate'])->name('profileUpdate');
        Route::get('/userPassword/{id}', [LoginController::class, 'userPassword'])->name('userPassword');
        Route::put('/password-update/{id}', [LoginController::class, 'passwordUpdate'])->name('passwordUpdate');


        // Employee management routes
        Route::get('/employee', [EmployeeController::class, 'index'])->name('employee.index');
        // Route::get('/employee/{user}', [EmployeeController::class, 'index'])->name('employee.index');
        Route::get('/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::post('/employee', [EmployeeController::class, 'store'])->name('employee.store');
        Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::put('/employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');
        Route::delete('/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');



        // Client management routes 
        Route::get('/client', [ClientController::class, 'index'])->name('clients.index');
        Route::get('/client/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('/client', [ClientController::class, 'store'])->name('clients.store');
        Route::get('/client/edit/{id}', [ClientController::class, 'edit'])->name('clients.edit');
        Route::put('/client/{id}', [ClientController::class, 'update'])->name('clients.update');
        Route::delete('/client/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');


        //Department management routes
        Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
        Route::get('/department/create', [DepartmentController::class, 'create'])->name('department.create');
        Route::post('/department', [DepartmentController::class, 'store'])->name('department.store');
        Route::get('/department/info/{id}', [DepartmentController::class, 'show'])->name('department.show');
        Route::post('/admin/department/assign/{id}', [DepartmentController::class, 'assignUser'])->name('department.assign');
        Route::delete('/admin/department/remove/{departmentId}/{userId}', [DepartmentController::class, 'detachUser'])->name('department.remove');
        Route::get('/department/edit/{id}', [DepartmentController::class, 'edit'])->name('department.edit');
        Route::put('/department/{id}', [DepartmentController::class, 'update'])->name('department.update');
        //  Route::get('/department/detete/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');
        Route::delete('/department/delete/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');
    

        //Project management Route
        Route::get('/project', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/project/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/project', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/project/edit/{id}', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::get('/project/edit/{id}', [ProjectController::class, 'edit'])->name('project.edit');
        Route::put('/project/{id}', [ProjectController::class, 'update'])->name('project.update');
        Route::post('/project/employee/list', [ProjectController::class, 'showByList'])->name('project.employee.list');
        Route::delete('/project/delete/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');

        //Module management Route
        Route::get('/module', [ModuleController::class, 'index'])->name('modules.index');
        Route::get('/module/create', [ModuleController::class, 'create'])->name('modules.create');
        Route::post('/module', [ModuleController::class, 'store'])->name('modules.store');
        Route::post('/project/module/list', [ModuleController::class, 'empList'])->name('modules.employee.list');
        Route::get('/module/edit/{id}', [ModuleController::class, 'edit'])->name('modules.edit');
        Route::put('/module/{id}', [ModuleController::class, 'update'])->name('modules.update');

        //Tasks management Route //
        Route::get('/task', [TaskController::class, 'index'])->name('task.index');
        Route::get('/task/create', [TaskController::class, 'create'])->name('task.create');
        Route::post('/task', [TaskController::class, 'store'])->name('task.store');
        // Route::post('/project/task/list', [TaskController::class, 'empList'])->name('task.module.list');
        // Route::post('/project/task/list', [TaskController::class, 'empList'])->name('task.employee.list');task.destroy

        Route::post('/project/task/modules', [TaskController::class, 'loadModules'])->name('task.module.list');
        Route::post('/project/task/employees', [TaskController::class, 'loadEmployees'])->name('task.employee.list');
        Route::get('/task/edit/{id}', [TaskController::class, 'edit'])->name('task.edit');
        Route::put('/task/{id}', [TaskController::class, 'update'])->name('task.update');
        Route::delete('/task/delete/{id}', [TaskController::class, 'destroy'])->name('task.destroy');
     


    });
});

// Redirect /login to /admin/login
Route::redirect('/login', '/admin/login');

// Fallback Route: Handle all undefined URLs
Route::fallback(function () {
    if (auth()->check()) {
        // If the user is logged in, redirect to the dashboard
        return redirect()->route('admin.dashboard.index');
    }

    // If the user is not logged in, redirect to the login page
    return redirect()->route('admin.login');
});

require __DIR__ . '/auth.php';
