<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProjectController;

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
        Route::delete('/admin/department/remove/{userId}/{departmentId}', [DepartmentController::class, 'detachUser'])->name('department.remove');
        Route::get('/department/edit/{id}', [DepartmentController::class, 'edit'])->name('department.edit');
        Route::put('/department/{id}', [DepartmentController::class, 'update'])->name('department.update');

        //  Route::get('/department/detete/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');
        Route::delete('/department/delete/{id}', [DepartmentController::class, 'destroy'])->name('department.destroy');
    
        Route::get('/project', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/project/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/project', [ProjectController::class, 'store'])->name('projects.store');

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
