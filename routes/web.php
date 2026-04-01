<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['student'])->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('dashboard');
    Route::post('/attendance/mark', [AttendanceController::class, 'store'])->name('attendance.mark');
    Route::post('/leave/request', [LeaveController::class, 'store'])->name('leave.request');
    Route::post('/profile/update', [AttendanceController::class, 'updateProfile'])->name('profile.update');
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks/{task}/submit', [TaskController::class, 'submit'])->name('tasks.submit');
});


Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users/store', [AdminController::class, 'storeUser'])->name('users.store');
    
    Route::get('/leaves', [AdminController::class, 'leaves'])->name('leaves');
    Route::get('/tasks/manage', [AdminController::class, 'allTasks'])->name('tasks.manage');
    Route::post('/leaves/{leave}/approve', [AdminController::class, 'approveLeave'])->name('leaves.approve');
    Route::post('/tasks/{task}/approve', [AdminController::class, 'approveTask'])->name('tasks.approve');
    
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::delete('/leaves/{leave}', [AdminController::class, 'deleteLeave'])->name('leaves.delete');
    
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [AdminController::class, 'editTask'])->name('tasks.edit');
    Route::post('/tasks/{task}/update', [AdminController::class, 'updateTask'])->name('tasks.update');
    Route::delete('/tasks/{task}', [AdminController::class, 'deleteTask'])->name('tasks.delete');
});

