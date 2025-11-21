<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|0
*/

Route::get('/', function () {
    return view('welcome');
});

// Admin dashboard (named for role-based redirects)
Route::get('/admin/dashboard', AdminDashboardController::class)
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('admin.dashboard');

// Staff dashboard (named for role-based redirects)
Route::get('/staff/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified', 'role:staff'])
    ->name('staff.dashboard');
// Contact form route
Route::get('/contact', function () {
    return view('contact_form');
});
Route::post('/contact', [Controller::class, 'store_contact'])->name('contact.store');
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/contact-enquiries', [Controller::class, 'all_contact'])->name('admin.contact_enquiries');
    Route::delete('/admin/contacts/delete/{id}', [Controller::class, 'destroy_contact']);
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notification routes
    Route::prefix('/api/notifications')->group(function () {
        Route::get('/unread-count', [NotificationsController::class, 'unreadCount'])->name('notifications.unread-count');
        Route::get('/recent', [NotificationsController::class, 'recent'])->name('notifications.recent');
        Route::post('/{id}/mark-read', [NotificationsController::class, 'markRead'])->name('notifications.mark-read');
        Route::post('/mark-all-read', [NotificationsController::class, 'markAllRead'])->name('notifications.mark-all-read');
    });
});
Route::get('/redirect-by-role', function () {
    if (auth()->user()->role === 'admin') {
        return redirect('/admin/dashboard');
    }

    return redirect('/staff/dashboard');
})->middleware(['auth']);

require __DIR__.'/auth.php';


