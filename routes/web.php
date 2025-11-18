<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public & Auth Routes
|--------------------------------------------------------------------------
*/

// Welcome / Home
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/', function () {
    return view('staff.dashboard');
})->name('staff.dashboard');


// Login Page
Route::get('/login', function () {
    return view('auth.login');
})->name('login');


/*
|--------------------------------------------------------------------------
| Staff Routes
|--------------------------------------------------------------------------
*/

Route::prefix('staff')->group(function () {
    Route::get('/profile-timesheets', function () {
        return view('staff.profile-timesheets');
    })->name('staff.profile-timesheets');

    Route::get('/timesheets-payslips', function () {
        return view('staff.timesheets-payslips');
    })->name('staff.timesheets-payslips');

    Route::get('/payslips-personal', function () {
        return view('staff.payslips-personal');
    })->name('staff.payslips-personal');

    Route::get('/certifications', function () {
        return view('staff.certifications');
    })->name('staff.certifications');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::get('/staff-management', function () {
        return view('admin.staff-management');
    })->name('admin.staff-management');

    Route::get('/timesheets', function () {
        return view('admin.timesheets');
    })->name('admin.timesheets');

    Route::get('/payroll', function () {
        return view('admin.payroll');
    })->name('admin.payroll');

    Route::get('/jobs-applications', function () {
        return view('admin.jobs-applications');
    })->name('admin.jobs-applications');
});
