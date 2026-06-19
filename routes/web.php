<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\MatchList;
use App\Livewire\RankingTable;

Route::middleware(['auth'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/partidos', MatchList::class)->name('matches.index');
    Route::get('/ranking', RankingTable::class)->name('ranking.index');
});

Route::redirect('/home', '/')->name('home');

require __DIR__.'/settings.php';

use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\AdminAccess;

// Admin area accessible only with ?key=ADMIN_ACCESS_KEY or X-Admin-Key header
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users')->middleware(AdminAccess::class);
Route::get('/admin/payments', [PaymentController::class, 'index'])->name('admin.payments.index')->middleware(AdminAccess::class);
Route::get('/admin/payments/create', [PaymentController::class, 'create'])->name('admin.payments.create')->middleware(AdminAccess::class);
Route::post('/admin/payments', [PaymentController::class, 'store'])->name('admin.payments.store')->middleware(AdminAccess::class);
Route::post('/admin/payments/sync', [PaymentController::class, 'sync'])->name('admin.payments.sync')->middleware(AdminAccess::class);
Route::get('/admin/payments/{payment}/edit', [PaymentController::class, 'edit'])->name('admin.payments.edit')->middleware(AdminAccess::class);
Route::put('/admin/payments/{payment}', [PaymentController::class, 'update'])->name('admin.payments.update')->middleware(AdminAccess::class);