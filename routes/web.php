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

use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\AdminAccess;

// Admin area accessible only with ?key=ADMIN_ACCESS_KEY or X-Admin-Key header
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users')->middleware(AdminAccess::class);