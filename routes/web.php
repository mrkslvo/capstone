<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\GrowthRecordController;
use App\Http\Controllers\ImmunizationDetailsController;
use App\Http\Controllers\ImmunizationRecordController;
use App\Http\Controllers\MaternalProfileController;
use App\Http\Controllers\MaternalRecordController;
use App\Http\Controllers\PostnatalRecordController;
use App\Http\Controllers\PrenatalRecordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// A D M I

Route::middleware('guest')->group(function () {
    Route::get('/', action: [AuthController::class, 'index'])->name('home');
    Route::get('/login', action: [AuthController::class, 'index'])->name('home');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [MaternalProfileController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/maternal', [MaternalProfileController::class, 'index'])->name('maternal');
    Route::post('/admin/maternal', [MaternalProfileController::class, 'store'])->name('maternal.store');
    Route::put('/admin/maternal/{maternalProfile}', [MaternalProfileController::class, 'update'])->name('maternal.update');
    Route::put('/admin/maternal-record/{maternalRecord}', [MaternalProfileController::class, 'updateMaternalRecordStatus'])->name('maternalRecord.update');
    Route::put('/admin/maternal-record-prenatal/{maternalRecord}', [MaternalProfileController::class, 'updateMaternalRecord'])->name('maternalRecordPresent.update');
    Route::post('/admin/prenatal', [PrenatalRecordController::class, 'store'])->name('prenatal.store');
    Route::post('/admin/postnatal', [PostnatalRecordController::class, 'store'])->name('postnatal.store');

    Route::get('/admin/child', [ChildProfileController::class, 'index'])->name('child');
    Route::post('/admin/child', [ChildProfileController::class, 'store'])->name('child.store');
    Route::put('/admin/child/{childProfile}', [ChildProfileController::class, 'update'])->name('child.update');

    Route::put('/admin/child/immunization-details/{immunizationDetails}', [ImmunizationRecordController::class, 'update'])->name('details.update');


    Route::post('/admin/immunization', [ImmunizationRecordController::class, 'store'])->name('immunization.store');
    Route::post('/admin/growth', [GrowthRecordController::class, 'store'])->name('growth.store');


    Route::get('/admin/schedule', [ScheduleController::class, 'index'])->name('schedule');
    Route::post('/admin/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
    Route::post('/admin/schedule/prental', [ScheduleController::class, 'addPrenatalSched'])->name('schedule.addSched');
    Route::post('/admin/schedule/postnatal', [ScheduleController::class, 'addPostnatalSched'])->name('schedule.addPostSched');
    Route::post('/admin/schedule/immunization', [ScheduleController::class, 'addImmunizationSched'])->name('schedule.addImmunizationSched');
    Route::put('/admin/schedule/done/{id}', [ScheduleController::class, 'done'])->name('done');

    Route::put('/admin/schedule/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');


    Route::get('/admin/user', [UserController::class, 'index'])->name('user');
    Route::post('/admin/user', [UserController::class, 'store'])->name('user.store');
    Route::put('/admin/user/{user}', [UserController::class, 'update'])->name('user.update');


    Route::get('/admin/report', [ReportController::class, 'index'])->name('report');
    Route::post('/admin/new-maternal-record/{maternalProfile}', [MaternalRecordController::class, 'addRecord'])->name('maternalRecord.addRecord');
    Route::put('/admin/update-maternal-record/{maternalRecord}', [MaternalRecordController::class, 'updateRecord'])->name('maternalRecord.updateRecord');
    Route::put('/admin/update-maternal-delivery/{delivery}', [DeliveryController::class, 'updateDelivery'])->name('delivery.update');
});

// Parent Dashboard
Route::middleware('role:parent')->group(function () {
    Route::get('/parent/dashboard', [DashboardController::class, 'parent']);
});

// BNS Dashboard
Route::middleware('role:bns')->group(function () {
    Route::get('/bns/dashboard', [DashboardController::class, 'bns']);
});

// RHU Dashboard
Route::middleware('role:rhu')->group(function () {
    Route::get('/rhu/dashboard', [DashboardController::class, 'rhu']);
});

// BHW Dashboard
Route::middleware('role:bhw')->group(function () {
    Route::get('/bhw/dashboard', [DashboardController::class, 'bhw']);
});


Route::get('/{any}', function () {
    return inertia('NotFound');
})->where('any', '.*');
