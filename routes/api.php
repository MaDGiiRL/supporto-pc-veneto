<?php

use Illuminate\Support\Facades\Route;

// routes/api.php
use App\Http\Controllers\Sor\SegnalazioneController;
use App\Http\Controllers\Sor\EventoController;
use App\Http\Controllers\Sor\ComunicazioniController;

Route::prefix('sor')->group(function () {
    // Segnalazioni
    Route::get('/segnalazioni',           [SegnalazioneController::class, 'index']);
    Route::post('/segnalazioni',           [SegnalazioneController::class, 'store']);
    Route::patch('/segnalazioni/{id}',      [SegnalazioneController::class, 'update']);
    Route::delete('/segnalazioni/{id}',      [SegnalazioneController::class, 'destroy']);
    Route::get('/segnalazioni/export.csv', [SegnalazioneController::class, 'export']);

    // Eventi
    Route::get('/eventi',                 [EventoController::class, 'index']);
    Route::get('/eventi/{id}',            [EventoController::class, 'show']);
    Route::post('/eventi',                 [EventoController::class, 'store']);
    Route::patch('/eventi/{id}/toggle',     [EventoController::class, 'toggle']);
    Route::get('/eventi/export.csv',      [EventoController::class, 'export']);

    // Comunicazioni dell’evento
    Route::get('/eventi/comunicazioni', [ComunicazioniController::class, 'index']);
    Route::post('/eventi/{evento}/comunicazioni', [ComunicazioniController::class, 'store']);
    Route::patch('/eventi/{evento}/comunicazioni/{id}', [ComunicazioniController::class, 'update']);
    Route::delete('/eventi/{evento}/comunicazioni/{id}', [ComunicazioniController::class, 'destroy']);
});
