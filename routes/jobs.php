<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\JobController;

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin/jobs')
    ->name('admin.jobs.')
    ->group(function () {
    Route::get('/', [JobController::class, 'index'])->name('index');

    Route::get('/create', [JobController::class, 'create'])->name('create');
    Route::post('/store', [JobController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [JobController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [JobController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [JobController::class, 'destroy'])->name('delete');
    });
 Route::get('/find-jobs', [JobController::class, 'showjobs'])->name('all_jobs');
 Route::get('/job/{id}', [JobController::class, 'job_Id'])->name('view_job');
 Route::get('/job/{id}/apply', [JobController::class, 'applyForm'])->name('apply_job');
 Route::post('/job/{id}/apply', [JobController::class, 'applySubmit'])->name('job.apply.submit');
 Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
     Route::get('/admin/applications', [JobController::class, 'all_application'])->name('admin.job.job_applications');
     Route::delete('/admin/applications/delete/{id}', [JobController::class, 'destroy_application'])->name('admin.job.applications.destroy');
 });

