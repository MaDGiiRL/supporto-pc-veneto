<?php

use App\Http\Controllers\ApplicativiController;
use App\Http\Controllers\SegnalazioniController;
use App\Http\Controllers\Sor\EventoController;
use App\Http\Controllers\Sor\SegnalazioneController;
use App\Http\Controllers\Sor\ComunicazioniController;
use App\Http\Controllers\Sor\CoordinamentoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;





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


Route::post('/logout', function (Request $request) {
    // Logout “pulito”
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Flash nel formato che la tua layout già usa
    return redirect()
        ->route('home')
        ->with('alert', [
            'type'    => 'success',
            'title'   => 'Logout effettuato',
            'message' => 'Hai effettuato l’uscita correttamente.'
        ]);
})->name('logout');


// Ping di test (pubblico, opzionale)
Route::get('/api/ping', fn() => response()->json(['ok' => true]));

// Rotte SOR protette da sessione Fortify
Route::middleware(['web', 'auth'])
    ->prefix('api/sor')
    ->group(function () {

        // Segnalazioni generiche
        Route::get('segnalazioni',                    [SegnalazioneController::class, 'index']);
        Route::post('segnalazioni',                   [SegnalazioneController::class, 'store']);
        Route::patch('segnalazioni/{segnalazione}',   [SegnalazioneController::class, 'update']);
        Route::delete('segnalazioni/{segnalazione}',  [SegnalazioneController::class, 'destroy']);
        Route::get('segnalazioni/export.csv',         [SegnalazioneController::class, 'export']);

        // Eventi
        Route::get('eventi',                          [EventoController::class, 'index']);
        Route::get('eventi/{evento}',                 [EventoController::class, 'show']);
        Route::post('eventi',                         [EventoController::class, 'store']);
        Route::patch('eventi/{evento}/toggle',        [EventoController::class, 'toggle']);
        Route::post('eventi/{evento}/comunicazioni', [ComunicazioniController::class, 'store']);
        Route::get('eventi/export.csv',               [EventoController::class, 'export']);

        // (opzionale) chi sono
        Route::get('me', fn() => auth()->user());
    });

    // PUBBLICHE (/sor) — come le altre tue SOR
Route::prefix('sor')->group(function () {
    Route::get('roles',                       [CoordinamentoController::class, 'roles']);
    Route::get('segnalazioni',                [CoordinamentoController::class, 'listSegnalazioni']); // aggiunge filtri status/assigned_to
    Route::patch('segnalazioni/{id}/assign',  [CoordinamentoController::class, 'assign']);
    Route::patch('segnalazioni/{id}/close',   [CoordinamentoController::class, 'close']);
    Route::post('segnalazioni/{id}/notes',    [CoordinamentoController::class, 'addNote']);
    Route::get('logs',                        [CoordinamentoController::class, 'logs']);
});

// PROTETTE (/api/sor) — matching esatto del fallback del client
Route::middleware(['web','auth'])->prefix('api/sor')->group(function () {
    Route::get('roles',                       [CoordinamentoController::class, 'roles']);
    Route::get('segnalazioni',                [CoordinamentoController::class, 'listSegnalazioni']);
    Route::patch('segnalazioni/{id}/assign',  [CoordinamentoController::class, 'assign']);
    Route::patch('segnalazioni/{id}/close',   [CoordinamentoController::class, 'close']);
    Route::post('segnalazioni/{id}/notes',    [CoordinamentoController::class, 'addNote']);
    Route::get('logs',                        [CoordinamentoController::class, 'logs']);
});

// use App\Http\Controllers\Sor\SegnalazioneOpsController;
Route::prefix('sor')->group(function () {
    Route::patch('/segnalazioni/{id}/assign', [\App\Http\Controllers\Sor\SegnalazioneOpsController::class, 'assign']);
    Route::patch('/segnalazioni/{id}/close',  [\App\Http\Controllers\Sor\SegnalazioneOpsController::class, 'close']);
    Route::post('/segnalazioni/{id}/notes',   [\App\Http\Controllers\Sor\SegnalazioneOpsController::class, 'addNote']);
    Route::get('/roles',                      [\App\Http\Controllers\Sor\SegnalazioneOpsController::class, 'roles']);
    Route::get('/logs',                       [\App\Http\Controllers\Sor\SegnalazioneOpsController::class, 'logs']);
});

Route::middleware(['web','auth'])->prefix('api/sor')->group(function () {
    Route::patch('/segnalazioni/{id}/assign', [\App\Http\Controllers\Sor\SegnalazioneOpsController::class, 'assign']);
    Route::patch('/segnalazioni/{id}/close',  [\App\Http\Controllers\Sor\SegnalazioneOpsController::class, 'close']);
    Route::post('/segnalazioni/{id}/notes',   [\App\Http\Controllers\Sor\SegnalazioneOpsController::class, 'addNote']);
    Route::get('/roles',                      [\App\Http\Controllers\Sor\SegnalazioneOpsController::class, 'roles']);
    Route::get('/logs',                       [\App\Http\Controllers\Sor\SegnalazioneOpsController::class, 'logs']);
});
