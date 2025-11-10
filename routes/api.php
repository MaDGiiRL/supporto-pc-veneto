<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sor\EventoController;
use App\Http\Controllers\Sor\ComunicazioniController;
use App\Http\Controllers\Sor\SegnalazioneController;

Route::prefix('sor')->group(function () {
    // Eventi
    Route::get('/eventi',                   [EventoController::class, 'index']);
    Route::get('/eventi/{id}',              [EventoController::class, 'show']);
    Route::post('/eventi',                  [EventoController::class, 'store']);
    Route::patch('/eventi/{id}/toggle',     [EventoController::class, 'toggle']);
    Route::get('/eventi/export.csv',        [EventoController::class, 'export']);
    Route::get('/eventi/{id}/export.csv',   [EventoController::class, 'exportSingle']);

    // Comunicazioni (nested sugli eventi)
    Route::post('/eventi/{evento}/comunicazioni',         [ComunicazioniController::class, 'store']);
    Route::patch('/eventi/{evento}/comunicazioni/{id}',   [ComunicazioniController::class, 'update']);
    Route::delete('/eventi/{evento}/comunicazioni/{id}',  [ComunicazioniController::class, 'destroy']);
    Route::get('/comunicazioni',                          [ComunicazioniController::class, 'index']);

    // Segnalazioni generiche
    Route::get('/segnalazioni',                [SegnalazioneController::class, 'index']);
    Route::post('/segnalazioni',               [SegnalazioneController::class, 'store']);
    Route::patch('/segnalazioni/{id}',         [SegnalazioneController::class, 'update']);
    Route::delete('/segnalazioni/{id}',        [SegnalazioneController::class, 'destroy']);
    Route::get('/segnalazioni/export.csv',     [SegnalazioneController::class, 'export']);
});
