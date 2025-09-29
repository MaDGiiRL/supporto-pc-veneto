<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicativiController;
use App\Http\Controllers\SegnalazioniController;

Route::view('/', 'home')->name('home');

Route::middleware('auth')->group(function () {
    Route::view('/cartografie', 'cartografie.index')->name('cartografie.index');
    Route::view('/percezione', 'percezione.index')->name('percezione.index');

    Route::get('/applicativi', [ApplicativiController::class, 'index'])->name('applicativi.index');
    Route::get('/applicativi/{slug}', [ApplicativiController::class, 'show'])->name('applicativi.show');
});


// Modulo "Segnalazioni" con sidebar + pannello
Route::get('/segnalazioni', [SegnalazioniController::class, 'index'])
    ->name('segnalazioni.index');

// Sezioni del modulo (dashboard, sinottico, ecc.)
Route::get('/segnalazioni/{page}', [SegnalazioniController::class, 'section'])
    ->where('page', '[A-Za-z0-9\-\_]+')
    ->name('segnalazioni.section');
