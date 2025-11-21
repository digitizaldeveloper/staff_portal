<?php

use App\Http\Controllers\Admin\PayslipController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin/payslips')
    ->name('admin.payslips.')
    ->group(function () {
        Route::get('/', [PayslipController::class, 'index'])->name('index');
        Route::get('/create', [PayslipController::class, 'create'])->name('create');
        Route::post('/store', [PayslipController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PayslipController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [PayslipController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [PayslipController::class, 'destroy'])->name('destroy');
    });

Route::get('/staff/payslips', [PayslipController::class, 'Show_payslip'])
    ->middleware(['auth', 'verified', 'role:staff'])
    ->name('staff.payslips-personal');
