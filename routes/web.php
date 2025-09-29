<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApplicativiController;

Route::view('/', 'home')->name('home');

// TUTTO protetto da login
Route::middleware('auth')->group(function () {
    Route::view('/cartografie', 'cartografie.index')->name('cartografie.index');
    Route::view('/percezione', 'percezione.index')->name('percezione.index');

    Route::get('/applicativi', [ApplicativiController::class, 'index'])->name('applicativi.index');
    Route::get('/applicativi/{slug}', [ApplicativiController::class, 'show'])->name('applicativi.show');
});
