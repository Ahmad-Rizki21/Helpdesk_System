<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SLAController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\LogController; // Ensure this class exists in the specified namespace
use App\Http\Controllers\UserController;

use App\Http\Controllers\DashboardController;

// use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/admin/login');
});



Route::get('/export/tickets', [ExportController::class, 'export'])->name('export.tickets');

Route::resource('slas', SLAController::class);
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


