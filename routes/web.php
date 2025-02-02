<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SLAController;
use App\Http\Controllers\UserRoleController;

Route::get('/', function () {
    return redirect('/admin/login');
});



Route::get('/export/tickets', [ExportController::class, 'export'])->name('export.tickets');

Route::resource('slas', SLAController::class);


