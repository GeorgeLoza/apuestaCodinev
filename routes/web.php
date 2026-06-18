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