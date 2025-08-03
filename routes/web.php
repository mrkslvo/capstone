<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BhwController;
use App\Http\Controllers\BnsController;
use App\Http\Controllers\ChildProfilesController;
use App\Http\Controllers\ImmunizationController;
use App\Http\Controllers\MaternalProfilesController;
use App\Http\Controllers\MaternalRecords;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\UserController;
use App\Models\Maternal_profiles;
use Illuminate\Support\Facades\Route;


// AUTHENTICATION

Route::get('/', [AuthController::class, 'role'])->name('role');
Route::get('/login', [AuthController::class, 'loginview'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');


Route::get('/admin/user-management', [UserController::class, 'index'])->name('users.index');
Route::post('/admin/user-management', [UserController::class, 'store'])->name('users.store');
Route::put('/admin/user-management/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/admin/user-management/{user}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/admin/schedules', [SchedulesController::class, 'index'])->name('schedules.index');
Route::post('/admin/schedules', [SchedulesController::class, 'store'])->name('schedules.store');
Route::put('/admin/schedules/{id}', [SchedulesController::class, 'update'])->name('schedules.update');

// DASHBOARD
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');


// MATERNAL PROFILES
Route::get('/admin/maternal-profiles', [MaternalProfilesController::class, 'index']);
Route::get('/admin/maternal-profiles/{id}', [MaternalProfilesController::class, 'show']);
Route::post('/admin/maternal-profiles', [MaternalProfilesController::class, 'store'])->name('maternal.store');
Route::put('/admin/maternal-profiles/{id}', [MaternalProfilesController::class, 'update'])->name('maternal.update');

// MATERNAL REPORTS
Route::get('/admin/maternal-reports', [ReportController::class, 'index']);

// CHILD PROFILES
Route::get('/admin/child-profiles', [ChildProfilesController::class, 'index']);
Route::post('/admin/child-profiles', [ChildProfilesController::class, 'store'])->name('child.store');
Route::put('/admin/child-profiles/{id}', [ChildProfilesController::class, 'update'])->name('child.update');


// BHW

Route::get('/bhw/dashboard', [BhwController::class, 'dashboard']);
Route::get('/bhw/maternal-profiles', [BhwController::class, 'maternalProfile']);
Route::get('/bhw/child-profiles', [BhwController::class, 'childPRofile']);
Route::get('/bhw/schedules', [BhwController::class, 'schedules']);
Route::get('/bhw/reports', [ReportController::class, 'bhwReport']);

// BNS

Route::get('/bns/dashboard', [BnsController::class, 'dashboard']);
Route::get('/bns/child-profiles', [BnsController::class, 'childPRofile']);
Route::get('/bns/schedules', [BnsController::class, 'schedules']);
Route::get('/bns/reports', [ReportController::class, 'bnsReport']);


// RHU
Route::get('/rhu/reports', [ReportController::class, 'rhuReport']);


// PARENT
Route::get('/parent/maternal-profiles', [ParentController::class, 'maternalProfile']);
Route::get('/parent/child-profiles', [ParentController::class, 'childPRofile']);

