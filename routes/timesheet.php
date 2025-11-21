<?php

use App\Http\Controllers\TimesheetsController;
use App\Http\Controllers\Admin\AdminTimesheetController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:staff'])->group(function () {
    Route::get('/staff/timesheets', [TimesheetsController::class, 'index'])->name('staff.timesheets.index');
    Route::get('/staff/timesheets/create', [TimesheetsController::class, 'create'])->name('staff.timesheets.create');
    Route::post('/staff/timesheets/store', [TimesheetsController::class, 'store'])->name('staff.timesheets.store');
    Route::get('/staff/timesheets/edit/{id}', [TimesheetsController::class, 'edit'])->name('staff.timesheets.edit');
    Route::put('/staff/timesheets/update/{id}', [TimesheetsController::class, 'update'])->name('staff.timesheets.update');
    Route::delete('/staff/timesheets/delete/{id}', [TimesheetsController::class, 'destroy'])->name('staff.timesheets.delete');
});

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/timesheets', [AdminTimesheetController::class, 'index'])->name('admin.timesheets.index');
    Route::get('/admin/timesheets/{id}', [AdminTimesheetController::class, 'show'])->name('admin.timesheets.show');
    Route::post('/admin/timesheets/{id}/approve', [AdminTimesheetController::class, 'approve'])->name('admin.timesheets.approve');
    Route::post('/admin/timesheets/{id}/reject', [AdminTimesheetController::class, 'reject'])->name('admin.timesheets.reject');
    Route::post('/admin/timesheets/{id}/notes', [AdminTimesheetController::class, 'saveNotes'])->name('admin.timesheets.notes');
    Route::get('/admin/timesheets-export', [AdminTimesheetController::class, 'exportCSV'])->name('admin.timesheets.export');
});