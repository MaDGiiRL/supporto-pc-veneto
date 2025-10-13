<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicativiController;
use App\Http\Controllers\SegnalazioniController;

Route::view('/', 'home')->name('home');

// Rotte protette
Route::middleware('auth')->group(function () {
    Route::view('/cartografie', 'cartografie.index')->name('cartografie.index');
    Route::view('/percezione', 'percezione.index')->name('percezione.index');

    // Applicativi (unica definizione, senza duplicati)
    Route::prefix('applicativi')->name('applicativi.')->group(function () {
        Route::get('/', [ApplicativiController::class, 'index'])->name('index');
        Route::get('{slug}', [ApplicativiController::class, 'show'])->name('show');
    });
});

// Segnalazioni
Route::redirect('/segnalazioni', '/segnalazioni/dashboard')->name('segnalazioni.index');
Route::get('/segnalazioni/{page?}', [SegnalazioniController::class, 'show'])
    ->where('page', '[A-Za-z0-9\-\_]+')
    ->name('segnalazioni.section');
