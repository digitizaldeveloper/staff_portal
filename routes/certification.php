<?php

use App\Http\Controllers\Admin\CertificationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin/certifications')
    ->name('admin.certifications.')
    ->group(function () {
        Route::get('/', [CertificationController::class, 'index'])->name('index');
        Route::get('/create', [CertificationController::class, 'create'])->name('create');
        Route::post('/store', [CertificationController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CertificationController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CertificationController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CertificationController::class, 'destroy'])->name('delete');
        Route::post('/approve/{id}', [CertificationController::class, 'approve'])->name('approve');
        Route::post('/reject/{id}', [CertificationController::class, 'reject'])->name('reject');
    });

Route::middleware(['auth', 'verified', 'role:staff'])->group(function () {
    Route::get('/staff/certifications', [CertificationController::class, 'staff_index'])->name('staff.certifications.index');
    Route::post('/staff/certifications/upload/{id}', [CertificationController::class, 'upload'])->name('staff.certifications.upload');
});