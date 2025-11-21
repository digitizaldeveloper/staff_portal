<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BlogCategoryController;

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin/blogs')
    ->name('admin.blogs.')
    ->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/create', [BlogController::class, 'create'])->name('create');
    Route::post('/store', [BlogController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [BlogController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [BlogController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [BlogController::class, 'destroy'])->name('delete');
});
// blog categories routes
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin/blog-categories')
    ->name('admin.blog_categories.')
    ->group(function () {
    Route::get('/', [BlogCategoryController::class, 'index'])->name('index');
    Route::get('/create', [BlogCategoryController::class, 'create'])->name('create');
    Route::post('/store', [BlogCategoryController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [BlogCategoryController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [BlogCategoryController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [BlogCategoryController::class, 'destroy'])->name('destroy');
});
