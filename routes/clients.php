<?php

use App\Http\Controllers\Admin\ClientController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin/clients')
    ->name('admin.clients.')
    ->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('index');
        Route::get('/create', [ClientController::class, 'create'])->name('create');
        Route::post('/store', [ClientController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ClientController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [ClientController::class, 'destroy'])->name('destroy');
    });